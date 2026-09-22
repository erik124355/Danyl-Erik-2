#!/usr/bin/env python3
"""Create GitHub issues from the issue definitions in ISSUES.md.

Requirements:
  - GitHub CLI (`gh`) installed and authenticated.
  - The authenticated user must have permission to create issues.

The script is idempotent by default: an issue is not created when an existing
issue has the same title. Use --dry-run to preview the operations.
"""

from __future__ import annotations

import argparse
import os
import re
import subprocess
import sys
from dataclasses import dataclass
from pathlib import Path


ISSUE_HEADING = re.compile(r"^## Issue \d+:\s*(.+?)\s*$", re.MULTILINE)
LABEL_LINE = re.compile(r"^\*\*Label:\*\*\s*(.+?)\s*$", re.MULTILINE)


@dataclass
class IssueDefinition:
    title: str
    labels: list[str]
    body: str


def run_gh(*args: str, capture: bool = True) -> str:
    command = ["gh", "api", *args]
    result = subprocess.run(command, text=True, capture_output=capture)
    if result.returncode != 0:
        message = result.stderr.strip() or "GitHub CLI command failed"
        raise RuntimeError(f"{' '.join(command)}\n{message}")
    return result.stdout.strip() if capture else ""


def parse_issue_file(path: Path) -> list[IssueDefinition]:
    text = path.read_text(encoding="utf-8")
    headings = list(ISSUE_HEADING.finditer(text))
    issues: list[IssueDefinition] = []

    for index, heading in enumerate(headings):
        start = heading.end()
        end = headings[index + 1].start() if index + 1 < len(headings) else text.find("## Kahden päivän aikataulu", start)
        if end == -1:
            end = len(text)
        section = text[start:end].strip()

        label_match = LABEL_LINE.search(section)
        labels: list[str] = []
        if label_match:
            labels = re.findall(r"`([^`]+)`", label_match.group(1))
            section = (section[: label_match.start()] + section[label_match.end() :]).strip()

        issues.append(IssueDefinition(title=heading.group(1), labels=labels, body=section))

    if not issues:
        raise ValueError(f"No issue definitions found in {path}")
    return issues


def repository_from_git() -> str | None:
    try:
        remote = subprocess.run(
            ["git", "config", "--get", "remote.origin.url"],
            text=True,
            capture_output=True,
            check=True,
        ).stdout.strip()
    except (subprocess.CalledProcessError, FileNotFoundError):
        return None

    match = re.search(r"github\.com[:/]([^/]+/[^/.]+?)(?:\.git)?$", remote)
    return match.group(1) if match else None


def existing_titles(repository: str) -> set[str]:
    output = run_gh(f"repos/{repository}/issues?state=all&per_page=100")
    # Avoid an extra dependency on jq; gh api --jq emits one title per line.
    # This fallback parser is retained for portability if the response is JSON.
    if output.startswith("["):
        import json

        return {item["title"] for item in json.loads(output)}
    return set(output.splitlines())


def ensure_label(repository: str, label: str, dry_run: bool) -> None:
    if dry_run:
        return
    # Creating an existing label returns HTTP 422. That is harmless and means
    # the label can be used without requiring manual repository setup.
    result = subprocess.run(
        [
            "gh",
            "api",
            "--method",
            "POST",
            f"repos/{repository}/labels",
            "-f",
            f"name={label}",
            "-f",
            "color=ededed",
        ],
        text=True,
        capture_output=True,
    )
    if result.returncode != 0 and "already_exists" not in result.stderr:
        raise RuntimeError(f"Could not create label {label}: {result.stderr.strip()}")


def create_issue(repository: str, issue: IssueDefinition, dry_run: bool) -> None:
    labels = issue.labels
    if dry_run:
        print(f"[dry-run] Would create: {issue.title} [{', '.join(labels)}]")
        return

    for label in labels:
        ensure_label(repository, label, dry_run=False)

    args = [
        "--method",
        "POST",
        f"repos/{repository}/issues",
        "-f",
        f"title={issue.title}",
        "-f",
        f"body={issue.body}",
    ]
    for label in labels:
        args.extend(["-f", f"labels[]={label}"])
    result = run_gh(*args)
    import json

    created = json.loads(result)
    print(f"Created #{created['number']}: {created['title']} ({created['html_url']})")


def main() -> int:
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("--source", type=Path, default=Path("ISSUES.md"), help="Issue definition file")
    parser.add_argument("--repo", default=None, help="GitHub repository in OWNER/NAME form")
    parser.add_argument("--dry-run", action="store_true", help="Preview without creating issues")
    args = parser.parse_args()

    repository = args.repo or os.environ.get("GITHUB_REPOSITORY") or repository_from_git()
    if not repository or "/" not in repository:
        parser.error("Could not determine repository; pass --repo OWNER/NAME")

    try:
        issues = parse_issue_file(args.source)
        titles = existing_titles(repository)
        for issue in issues:
            if issue.title in titles:
                print(f"Skipping existing issue: {issue.title}")
                continue
            create_issue(repository, issue, args.dry_run)
    except (OSError, RuntimeError, ValueError) as error:
        print(f"Error: {error}", file=sys.stderr)
        return 1
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

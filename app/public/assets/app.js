const container = document.getElementById('spots');
const form = document.getElementById('spotForm');
const message = document.getElementById('message');

function escapeHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function showMessage(text, color = '#4ade80') {
    if (message) {
        message.textContent = text;
        message.style.color = color;
    }
}

async function loadSpots() {
    container.innerHTML = '<p class="loading">Ladataan retkikohteita...</p>';

    try {
        const response = await fetch('/api/destinations');
        const result = await response.json();

        if (!response.ok || result.status !== 'ok') {
            throw new Error(result.message || 'Tietojen lataus epäonnistui');
        }

        const spots = result.data || [];
        window.initialSpots = spots;

        if (spots.length === 0) {
            container.innerHTML = '<p class="empty-state">Retkikohteita ei löytynyt.</p>';
            return;
        }

        container.innerHTML = spots.map(spot => `
            <article class="card">
                <h2>${escapeHtml(spot.name)}</h2>
                <p><strong>Sijainti:</strong> ${escapeHtml(spot.location)}</p>
                <p><strong>Kuvaus:</strong> ${escapeHtml(spot.description || 'Ei kuvausta.')}</p>
                <p><strong>Leveysaste:</strong> ${spot.latitude ?? '-'}</p>
                <p><strong>Pituusaste:</strong> ${spot.longitude ?? '-'}</p>
                <p><strong>Tyyppi:</strong> ${escapeHtml(spot.type || '-')}</p>
                <p><strong>Vaikeustaso:</strong> ${escapeHtml(spot.difficulty || '-')}</p>
                <p><strong>Suunniteltu retkipäivä:</strong> ${spot.planned_date || '-'}</p>

                <button class="edit-btn" data-id="${spot.id}">Muokkaa</button>
                <button class="delete-btn" data-id="${spot.id}">Poista</button>
            </article>
        `).join('');
    } catch (error) {
        container.innerHTML = `
            <p class="error-state">
                Tietojen lataus epäonnistui: ${escapeHtml(error.message)}
            </p>
        `;
    }
}

container.addEventListener('click', async event => {
    const id = event.target.dataset.id;

    if (!id) {
        return;
    }

    if (event.target.classList.contains('edit-btn')) {
        const spot = window.initialSpots.find(item => String(item.id) === id);

        document.getElementById('spotId').value = spot.id;
        document.getElementById('name').value = spot.name;
        document.getElementById('location').value = spot.location;
        document.getElementById('description').value = spot.description || '';
        document.getElementById('latitude').value = spot.latitude || '';
        document.getElementById('longitude').value = spot.longitude || '';
        document.getElementById('type').value = spot.type || '';
        document.getElementById('difficulty').value = spot.difficulty || '';
        document.getElementById('planned_date').value = spot.planned_date || '';

        document.getElementById('submitButton').textContent = 'Päivitä retkikohde';
    }

    if (event.target.classList.contains('delete-btn')) {
        if (!confirm('Haluatko varmasti poistaa retkikohteen?')) {
            return;
        }

        const response = await fetch(`/api/destinations/${id}`, {
            method: 'DELETE'
        });

        const result = await response.json();

        if (!response.ok) {
            showMessage(result.message || 'Poisto epäonnistui', '#fca5a5');
            return;
        }

        showMessage('Retkikohde poistettu.');
        await loadSpots();
    }
});

form.addEventListener('submit', async event => {
    event.preventDefault();

    const id = document.getElementById('spotId').value;

    const payload = {
        name: document.getElementById('name').value.trim(),
        location: document.getElementById('location').value.trim(),
        description: document.getElementById('description').value.trim(),
        latitude: document.getElementById('latitude').value,
        longitude: document.getElementById('longitude').value,
        type: document.getElementById('type').value.trim(),
        difficulty: document.getElementById('difficulty').value.trim(),
        planned_date: document.getElementById('planned_date').value
    };

    const response = await fetch(
        id ? `/api/destinations/${id}` : '/api/destinations',
        {
            method: id ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        }
    );

    const result = await response.json();

    if (!response.ok) {
        showMessage(result.message || 'Toiminto epäonnistui', '#fca5a5');
        return;
    }

    showMessage(id ? 'Retkikohde päivitetty.' : 'Retkikohde lisätty.');
    form.reset();
    document.getElementById('spotId').value = '';
    document.getElementById('submitButton').textContent = 'Lisää retkikohde';

    await loadSpots();
});

loadSpots();
async function loadSpots() {
    const container = document.getElementById('spots');

    try {
        const response = await fetch('/api/spots');
        const result = await response.json();

        if (!response.ok || result.status !== 'ok') {
            throw new Error(result.message || 'Tietojen lataus epäonnistui');
        }

        const spots = result.data || [];

        container.innerHTML = spots.map(spot => `
            <div class="card">
                <h2>${spot.name}</h2>
                <p><strong>Sijainti:</strong> ${spot.location}</p>
                <p>${spot.description || 'Ei kuvausta.'}</p>
                <button class="delete-btn" data-id="${spot.id}">Poista</button>
            </div>
        `).join('');

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', async () => {
                const id = button.getAttribute('data-id');

                try {
                    const response = await fetch(`/api/spots/${id}`, {
                        method: 'DELETE'
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Poisto epäonnistui');
                    }

                    const message = document.getElementById('message');
                    message.textContent = 'Retkikohde poistettu.';
                    message.style.color = '#4ade80';

                    await loadSpots();
                } catch (error) {
                    const message = document.getElementById('message');
                    message.textContent = error.message;
                    message.style.color = '#fca5a5';
                }
            });
        });
    } catch (error) {
        container.innerHTML = `<div class="card"><p>${error.message}</p></div>`;
    }
}

document.getElementById('spotForm').addEventListener('submit', async (event) => {
    event.preventDefault();

    const message = document.getElementById('message');
    const payload = {
        name: document.getElementById('name').value,
        location: document.getElementById('location').value,
        description: document.getElementById('description').value
    };

    try {
        const response = await fetch('/api/spots', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Lisäys epäonnistui');
        }

        message.textContent = 'Retkikohde lisätty onnistuneesti.';
        message.style.color = '#4ade80';
        document.getElementById('spotForm').reset();
        await loadSpots();
    } catch (error) {
        message.textContent = error.message;
        message.style.color = '#fca5a5';
    }
});

if (typeof initialSpots !== 'undefined') {
    const container = document.getElementById('spots');

    container.innerHTML = initialSpots.map(spot => `
        <div class="card">
            <h2>${spot.name}</h2>
            <p><strong>Sijainti:</strong> ${spot.location}</p>
            <p>${spot.description || 'Ei kuvausta.'}</p>
            <button class="delete-btn" data-id="${spot.id}">Poista</button>
        </div>
    `).join('');

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', async () => {
            const id = button.getAttribute('data-id');

            try {
                const response = await fetch(`/api/spots/${id}`, {
                    method: 'DELETE'
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Poisto epäonnistui');
                }

                const message = document.getElementById('message');
                message.textContent = 'Retkikohde poistettu.';
                message.style.color = '#4ade80';

                await loadSpots();
            } catch (error) {
                const message = document.getElementById('message');
                message.textContent = error.message;
                message.style.color = '#fca5a5';
            }
        });
    });
} else {
    loadSpots();
}
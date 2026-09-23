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
                <p><strong>Kuvaus:</strong> ${spot.description || 'Ei kuvausta.'}</p>
                <p><strong>Leveysaste:</strong> ${spot.latitude}</p>
                <p><strong>Pituusaste:</strong> ${spot.longitude}</p>
                <p><strong>Tyyppi:</strong> ${spot.type}</p>
                <p><strong>Vaikeustaso:</strong> ${spot.difficulty}</p>
                <p><strong>Suunniteltu retkipäivä:</strong> ${spot.planned_date}</p>

                <button class="edit-btn" data-id="${spot.id}">Muokkaa</button>
                <button class="delete-btn" data-id="${spot.id}">Poista</button>
            </div>
        `).join('');

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const spot = window.initialSpots?.find(item => String(item.id) === String(id));

                if (!spot) return;

                document.getElementById('spotId').value = spot.id;
                document.getElementById('name').value = spot.name;
                document.getElementById('location').value = spot.location;
                document.getElementById('description').value = spot.description || '';

                const submitButton = document.getElementById('submitButton');
                submitButton.textContent = 'Päivitä retkikohde';
            });
        });

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

                    window.initialSpots = window.initialSpots.filter(item => String(item.id) !== String(id));
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

const form = document.getElementById('spotForm');

if (form) {
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = document.getElementById('message');
        const spotId = document.getElementById('spotId').value;
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

        try {
            let response;

            if (spotId) {
                response = await fetch(`/api/spots/${spotId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    },
                    body: JSON.stringify(payload)
                });
            } else {
                response = await fetch('/api/spots', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    },
                    body: JSON.stringify(payload)
                });
            }

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Toiminto epäonnistui');
            }

            message.textContent = spotId
                ? 'Retkikohde päivitetty.'
                : 'Retkikohde lisätty onnistuneesti.';
            message.style.color = '#4ade80';

            form.reset();
            document.getElementById('spotId').value = '';
            document.getElementById('submitButton').textContent = 'Lisää retkikohde';

            window.initialSpots = await fetch('/api/spots').then(r => r.json()).then(r => r.data || []);
            await loadSpots();
        } catch (error) {
            message.textContent = error.message;
            message.style.color = '#fca5a5';
        }
    });
}

if (typeof window.initialSpots !== 'undefined') {
    const container = document.getElementById('spots');

    container.innerHTML = window.initialSpots.map(spot => `
        <div class="card">
            <h2>${spot.name}</h2>
            <p><strong>Sijainti:</strong> ${spot.location}</p>
            <p><strong>Kuvaus:</strong> ${spot.description || 'Ei kuvausta.'}</p>
            <p><strong>Leveysaste:</strong> ${spot.latitude}</p>
            <p><strong>Pituusaste:</strong> ${spot.longitude}</p>
            <p><strong>Tyyppi:</strong> ${spot.type}</p>
            <p><strong>Vaikeustaso:</strong> ${spot.difficulty}</p>
            <p><strong>Suunniteltu retkipäivä:</strong> ${spot.planned_date}</p>

            <button class="edit-btn" data-id="${spot.id}">Muokkaa</button>
            <button class="delete-btn" data-id="${spot.id}">Poista</button>
        </div>
    `).join('');

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const spot = window.initialSpots.find(item => String(item.id) === String(id));

            if (!spot) return;

            document.getElementById('spotId').value = spot.id;
            document.getElementById('name').value = spot.name;
            document.getElementById('location').value = spot.location;
            document.getElementById('description').value = spot.description || '';

            const submitButton = document.getElementById('submitButton');
            submitButton.textContent = 'Päivitä retkikohde';
        });
    });

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

                window.initialSpots = window.initialSpots.filter(item => String(item.id) !== String(id));
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
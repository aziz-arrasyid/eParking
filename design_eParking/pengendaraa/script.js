// Ambil elemen input pencarian
const filterInput = document.getElementById('filter');

// Ambil semua kartu parkir
const parkingCards = document.querySelectorAll('.parking-card');

// Tambahkan event listener untuk input pencarian
filterInput.addEventListener('input', filterParkingCards);

function filterParkingCards() {
    const searchTerm = filterInput.value.toLowerCase();

    parkingCards.forEach((card) => {
        const cardText = card.textContent.toLowerCase();

        if (cardText.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const filterInput = document.getElementById('filter');
    const cards = document.querySelectorAll('.custom-card');

    filterInput.addEventListener('input', function () {
        const searchTerm = filterInput.value.toLowerCase();

        cards.forEach(function (card) {
            const cardText = card.textContent.toLowerCase();
            if (cardText.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

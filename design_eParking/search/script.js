document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search-input");
  const searchButton = document.querySelector("button[type='button']");
  const cards = document.querySelectorAll(".custom-card");

  searchButton.addEventListener("click", function () {
      const searchTerm = searchInput.value.toLowerCase();

      let hasResults = false; // Menentukan apakah ada hasil pencarian

      cards.forEach(function (card) {
          const cardText = card.textContent.toLowerCase();
          if (cardText.includes(searchTerm)) {
              card.style.display = "block";
              hasResults = true; // Ada hasil pencarian
          } else {
              card.style.display = "none";
          }
      });

      // Menampilkan modal jika tidak ada hasil
      const noResultModal = document.getElementById("no-result-modal");
      if (!hasResults) {
          noResultModal.style.display = "block";
      } else {
          noResultModal.style.display = "none";
      }
  });
});

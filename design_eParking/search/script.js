function search() {
    let input, filter, cards, cardContainer, span, i, txtValue;
    input = document.getElementById("filter");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("parkingData");
    cards = cardContainer.getElementsByClassName("col-md-6");

    for (i = 0; i < cards.length; i++) {
        span = cards[i].querySelector(".small-card span");
        txtValue = span.textContent || span.innerText;

        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "";
        } else {
            cards[i].style.display = "none";
        }
    }
}
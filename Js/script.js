
document.addEventListener("DOMContentLoaded", function () {
    const burger = document.getElementById("burger");
    const nav = document.querySelector("nav");
    const closeButton = document.querySelector("nav button");

    // Ouvrir le menu au clic sur le burger
    burger.addEventListener("click", function () {
        nav.classList.add("active");
    });

    // Fermer le menu au clic sur le bouton "X"
    closeButton.addEventListener("click", function () {
        nav.classList.remove("active");
    });

    // Fermer le menu si on clique en dehors
    document.addEventListener("click", function (event) {
        if (!nav.contains(event.target) && !burger.contains(event.target)) {
            nav.classList.remove("active");
        }
    });
});

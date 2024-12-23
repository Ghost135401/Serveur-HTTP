document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("modifier-form");
    const submitButton = document.getElementById("submit-button");
    const confirmationDialog = document.getElementById("confirmation-dialog");
    const confirmYesButton = document.getElementById("confirm-yes");
    const confirmNoButton = document.getElementById("confirm-no");

    // Empêche la soumission du formulaire quand le bouton de modification est cliqué
    form.addEventListener("submit", function (event) {
        event.preventDefault();  // Empêche le formulaire de se soumettre immédiatement
        confirmationDialog.style.display = "block";  // Affiche la boîte de confirmation
    });

    // Si l'utilisateur clique sur "Oui", soumet le formulaire
    confirmYesButton.addEventListener("click", function () {
        confirmationDialog.style.display = "none";  // Cache la boîte de confirmation
        form.submit();  // Soumet réellement le formulaire
    });

    // Si l'utilisateur clique sur "Non", cache la boîte de confirmation sans soumettre
    confirmNoButton.addEventListener("click", function () {
        confirmationDialog.style.display = "none";  // Cache la boîte de confirmation
    });
});


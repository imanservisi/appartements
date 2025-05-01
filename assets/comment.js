"use-strict";

$(document).ready(function () {
    $('#commentairePrimeAssurance').on('show.bs.modal', function (event) {
        // Bouton qui a déclenché la modal
        var button = $(event.relatedTarget);
        // Récupérer l'ID de la prime depuis l'attribut data-id
        var primeCommentaire = button.data('commentaire');
        // Insérer l'ID dans la modal
        $('#primeCommentaire').text(primeCommentaire);
    });
    $('#commentaireLoyer').on('show.bs.modal', function (event) {
        // Bouton qui a déclenché la modal
        var button = $(event.relatedTarget);
        // Récupérer l'ID du loyer depuis l'attribut data-id
        var loyerCommentaire = button.data('commentaire');
        // Insérer l'ID dans la modal
        $('#loyerCommentaire').text(loyerCommentaire);
    });
});
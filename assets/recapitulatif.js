"use-strict";

jQuery('#recapitulatif').on('click', function () {
    const residence = jQuery(this).attr('data-residence');
    let annee = jQuery(this).attr('annee');
    // Si annee non choisie, on définit à l'année n-1
    if (typeof annee === 'undefined') {
        annee = new Date().getFullYear() -1;
    }
    const montants = JSON.parse(jQuery(this).attr('data-montants'));
    
    console.log(montants);

    jQuery.ajax({
        url: '/genererRecapitulatif/' + residence,
        type: 'POST',
        data: {
            annee: annee,
            montants: JSON.stringify(montants)
        },
        success: function(data) {
            alert('Les données ont été enregistrées avec succès');
        }
    })
})
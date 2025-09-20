"use-strict";

jQuery('#recapitulatif').on('click', function () {
    const residence = jQuery(this).attr('data-residence');
    const loyer = jQuery(this).attr('data-loyer');
    let annee = jQuery(this).attr('annee');
    // Si annee non choisie, on définit à l'année n-1
    if (typeof annee === 'undefined') {
        annee = new Date().getFullYear() -1;
    }
    const totalRecettes = jQuery(this).attr('data-totalrecettes');
    const fraisGestion = jQuery(this).attr('data-fraisgestion');
    const autresFrais = jQuery(this).attr('data-autresfrais');
    const primesAssurances = jQuery(this).attr('data-primesassurances');
    const travaux = jQuery(this).attr('data-travaux');
    const taxesFoncieres = jQuery(this).attr('data-taxesfoncieres');
    const provisions = jQuery(this).attr('data-provisions');
    const autresProvisions = jQuery(this).attr('data-autresprovisions');
    const regul = jQuery(this).attr('data-regul');
    const autresRegul = jQuery(this).attr('data-autresregul');
    const fraisCharges = jQuery(this).attr('data-fraischarges');
    const emprunt = jQuery(this).attr('data-emprunt');
    const revenusFonciers = jQuery(this).attr('data-revenusfonciers');
    jQuery.ajax({
        url: '/genererRecapitulatif/' + residence,
        type: 'POST',
        data: {
            annee: annee,
            loyer: loyer,
            totalRecettes: totalRecettes,
            fraisGestion: fraisGestion,
            autresFrais: autresFrais,
            primesAssurances: primesAssurances,
            travaux: travaux,
            taxesFoncieres: taxesFoncieres,
            provisions: provisions,
            autresProvisions: autresProvisions,
            regul: regul,
            autresRegul: autresRegul,
            fraisCharges: fraisCharges,
            emprunt: emprunt,
            revenusFonciers: revenusFonciers,
        },
        success: function(data) {
            alert('Les données ont été enregistrées avec succès');
        }
    })
})
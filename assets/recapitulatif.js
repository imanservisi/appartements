"use-strict";

jQuery('#recapitulatif').on('click', function () {
    const residence = jQuery(this).attr('data-residence');
    const loyer = jQuery(this).attr('data-loyer');
    jQuery.ajax({
        url: '/genererRecapitulatif/' + residence,
        type: 'POST',
        data: {
            loyer: loyer
        },
        success: function(data) {
            console.log(data);
        }
    })
})
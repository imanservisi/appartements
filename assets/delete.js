"use-strict";

const deleteText = "Etes vous sûr de vouloir supprimer cet élément ?";

jQuery('.delete').on('click', function() {
    let id = jQuery(this).attr('data-id');
    deleteUrl = id + '/delete';
    if (confirm(deleteText)) {
        ajaxRequest(deleteUrl, id);
    }
});

jQuery('.deleteResidenceChild').on('click', function() {
    let id = jQuery(this).attr('data-id');
    let residenceId = jQuery(this).attr('data-residence-id');
    let url = jQuery(this).attr('data-url');
    let keyword = jQuery(this).attr('data-keyword');
    let deleteUrl = url + '/residence/' + residenceId + '/' + keyword + '/' + id + '/delete';
    if (confirm(deleteText)) {
        ajaxRequest(deleteUrl, id);
    }

});

jQuery('.deleteResidenceLotChild').on('click', function() {
    let id = jQuery(this).attr('data-id');
    let residenceId = jQuery(this).attr('data-residence-id');
    let lotId = jQuery(this).attr('data-lot-id');
    let url = jQuery(this).attr('data-url');
    let keyword = jQuery(this).attr('data-keyword');
    let deleteUrl = url + '/residence/' + residenceId + '/lot/' + lotId + '/' + keyword + '/' + id + '/delete';
    if (confirm(deleteText)) {
        ajaxRequest(deleteUrl, id);
    }
});

jQuery('.deleteResidenceLotOtherChild').on('click', function() {
    let id = jQuery(this).attr('data-id');
    let residenceId = jQuery(this).attr('data-residence-id');
    let lotId = jQuery(this).attr('data-lot-id');
    let url = jQuery(this).attr('data-url');
    let keyword = jQuery(this).attr('data-keyword');
    let childKeyword = jQuery(this).attr('data-child-keyword');
    let childId = jQuery(this).attr('data-child-id');
    let deleteUrl = url + '/residence/' + residenceId + '/lot/' + lotId + '/' + childKeyword + '/' + childId + '/' + keyword + '/' + id + '/delete';
    if (confirm(deleteText)) {
        ajaxRequest(deleteUrl, id);
    }
})

function ajaxRequest(url, id)
{
    jQuery.ajax({
        url: url,
        type: 'GET',
        data: {
            id: id,
        },
        success: function(data) {
            jQuery('.reload').html(data);
        }
    })
}

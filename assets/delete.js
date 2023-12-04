"use-strict";

const deleteText = "Etes vous sûr de vouloir supprimer cet élément ?";
console.log(deleteText);

jQuery('.delete').on('click', function() {
    id = jQuery(this).attr('data-id');
    if (confirm(deleteText)) {
        jQuery.ajax({
            url: id + '/delete',
            type: 'GET',
            data: {
                id: id
            },
            success: function(data) {
                jQuery('.reload').html(data);
            }
        })
    }
});

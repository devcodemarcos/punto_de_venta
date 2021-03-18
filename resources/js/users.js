$('#tblUsers').on('click', '.btnDeleteUser', function(e) {
    let user = $(this);
    $.confirm({
        title: 'Eliminar usuario',
        content: '¿Esta seguro de eliminar este usuario?',
        type: 'blue',
        typeAnimated: true,
        useBootstrap: false,
        boxWidth: '400px',
        buttons: {
            tryAgain: {
                text: 'Eliminar',
                btnClass: 'btn-blue',
                action: function(){
                    $.ajax({
                        url: user.data('route-delete'),
                        type: 'delete',
                        dataType: 'json'
                    })
                    .done(response => {
                        let total = parseInt($('#totalUsers').text()) - 1;
                        $('#totalUsers').text(total);
                        user.closest('tr').fadeOut();

                        notification({
                            type: 'success',
                            title: '&#x2705; &nbsp; Buen trabajo',
                            message: response.message
                        });
                    });
                }
            },
            close: {
                text: 'Cancelar'
            }
        }
    });
});

$('#tblUsers').on('click', '.btnEditProvider', function(e) {
    let provider = $(this);
    window.location.href = provider.data('route-edit');
});
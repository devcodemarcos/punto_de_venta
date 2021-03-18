$('#frmProviders').validate({
    rules: {
        name: {
            required: true,
            minlength: 5
        },
        phone: {
            required: true,
            digits: true,
            minlength: 10,
            maxlength: 12
        },
        email: {
            email: true
        }
    },
    messages: {
        name: {
            required: 'El nombre del proveedor es obligatorio',
            minlength: 'El nombre del proveedor debe tener mínimo 5 caracteres'
        },
        phone: {
            required: 'El número teléfonico es obligatorio',
            digits: 'Ingrese solo dígitos',
            minlength: 'El numero de teléfono debe tener minímo 10 dígitos',
            maxlength: 'El numero de teléfono debe tener máximo 12 dígitos'
        },
        email: {
            email: 'No es un correo válido'
        }
    },
    submitHandler: function (form) {
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            dataType: 'json',
            data: $(form).serialize()
        })
        .done(function (response) {
            if(form.elements['_method'].value === 'POST') {
                $(form).trigger('reset');
                $('#name').trigger('focus');
            }
            notification({
                type: 'success',
                title: '&#x2705; &nbsp; Buen trabajo',
                message: response.message
            });
        })
        .fail(function ($jqXHR, textStatus, errorThrown) {
            var response = $jqXHR.responseJSON;
            notification({
                type: 'error',
                title: '&#10060; &nbsp; ERROR',
                message: response.message
            });
        });
    }
});

$('#tblProviders').on('click', '.btnDeleteProvider', function(e) {
    let provider = $(this);
    $.confirm({
        title: 'Eliminar proveedor',
        content: '¿Esta seguro de eliminar este proveedor?',
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
                        url: provider.data('route-delete'),
                        type: 'delete',
                        dataType: 'json'
                    })
                    .done(response => {
                        let total = parseInt($('#totalProviders').text()) - 1;
                        $('#totalProviders').text(total);
                        provider.closest('tr').fadeOut();

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

$('#tblProviders').on('click', '.btnEditProvider', function(e) {
    let provider = $(this);
    window.location.href = provider.data('route-edit');
});
$('#frmProducts').validate({
    rules: {
        barcode: {
            required: true,
            minlength: 3,
            maxlength: 13
        },
        name: {
            required: true
        },
        stock: {
            required: true,
            number: true,
            maxlength: 6,
            min: 1
        },
        minimum_stock: {
            required: true,
            number: true,
            maxlength: 6,
            min: 1
        },
        purchase_price: {
            required: true,
            number: true
        },
        sale_price: {
            required: true,
            number: true
        },
        unit_id: {
            min: 1
        }
    },
    messages: {
        barcode: {
            required: 'El código de barras es obligatorio',
            minlength: 'El código de barras debe tener minímo 3 dígitos',
            maxlength: 'El código de barras debe tener máximo 13 dígitos'
        },
        name: {
            required: 'El nombre del producto es obligatorio'
        },
        stock: {
            required: 'El stock del producto es obligatorio',
            maxlength: 'El stock debe tener máximo 6 dígitos',
            number: 'Ingrese solo dígitos',
            min: 'El stock debe ser mayor o igual a 1'
        },
        minimum_stock: {
            required: 'El stock mínimo del producto es olbigatorio',
            maxlength: 'El stock mínimo debe tener máximo 6 dígitos',
            number: 'Ingrese solo dígitos',
            min: 'El stock mínimo debe ser mayor o igual a 1'
        },
        purchase_price: {
            required: 'El precio de compra es obligatorio',
            number: 'Ingrese solo dígitos'
        },
        sale_price: {
            required: 'El precio de venta es obligatorio',
            number: 'Ingrese solo dígitos'
        },
        unit_id: {
            min: 'Seleccione un tipo de venta'
        }
    },
    submitHandler: function (form) {
        let formData = new FormData(form);
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
        })
            .done(function (response) {
                if (form.elements['_method'].value === 'POST') {
                    $(form).trigger('reset');
                    $('#barcode').trigger('focus');
                }
                $.notifyBar({ cssClass: "success", html: response.message });
            })
            .fail(function ($jqXHR, textStatus, errorThrown) {
                var response = $jqXHR.responseJSON;
                $.notifyBar({ cssClass: "error", html: response.message });
            });
    }
});

$('#tblProducts').on('click', '.btnDeleteProduct', function (e) {
    let product = $(this);
    $.confirm({
        title: 'Eliminar producto',
        content: '¿Esta seguro de eliminar este producto?',
        type: 'blue',
        typeAnimated: true,
        useBootstrap: false,
        boxWidth: '400px',
        buttons: {
            tryAgain: {
                text: 'Eliminar',
                btnClass: 'btn-blue',
                action: function () {
                    $.ajax({
                        url: product.data('route-delete'),
                        type: 'delete',
                        dataType: 'json'
                    })
                        .done(response => {
                            let total = parseInt($('#totalProducts').text()) - 1;
                            $('#totalProducts').text(total);
                            product.closest('tr').fadeOut();
                            $.notifyBar({ cssClass: "success", html: response.message });
                        });
                }
            },
            close: {
                text: 'Cancelar'
            }
        }
    });
});

$('#tblProducts').on('click', '.btnEditProduct', function (e) {
    let product = $(this);
    window.location.href = product.data('route-edit');
});

let barcode = $('#tooltip-barcode');

barcode.tooltipster({
    position: 'top',
    animation: 'grow'
});

barcode.on('click', function () {
    let code = $(this);
    $.ajax({
        url: code.data('route'),
        method: 'POST',
        dataType: 'json'
    })
        .done(function (response) {
            $('#barcode').val(response.barcode);
        });
});
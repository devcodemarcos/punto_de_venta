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
            maxlength: 4,
            number: true
        },
        minimum_stock: {
            required: true,
            maxlength: 4,
            number: true
        },
        purchase_price: {
            required: true,
            number: true
        },
        sale_price: {
            required: true,
            number: true
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
            maxlength: 'El stock debe tener máximo 4 dígitos',
            number: 'Ingrese solo dígitos'
        },
        minimum_stock: {
            required: 'El stock mínimo del producto es olbigatorio',
            maxlength: 'El stock mínimo debe tener máximo 4 dígitos',
            number: 'Ingrese solo dígitos'
        },
        purchase_price: {
            required: 'El precio de compra es obligatorio',
            number: 'Ingrese solo dígitos'
        },
        sale_price: {
            required: 'El precio de venta es obligatorio',
            number: 'Ingrese solo dígitos'
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

// $('#tblProducts').on('dblclick', '.td-product-stock', function (e) {
// e.stopPropagation();
// let td = $(this);
// let stock = td.find('.product-stock').text().trim();
// let input = `<input value="${stock}" type="number" name="stock" onkeypress="return isNumberKey(event)" class="edit-stock text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-2/4 px-3 py-2"/>`;

// td.find('.product-stock').html(input);
// $('.edit-stock').trigger('focus');
// });
products_list = {};

$('#frm-barcode').on('submit', function (e) {
    e.preventDefault();
    var frm = $(this);
    $.ajax({
        url: frm.attr('action'),
        method: frm.attr('method'),
        data: frm.serialize(),
        dataType: 'json'
    })
        .done(function (response) {
            appendToObject(response);
            displayToTable();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 404) {
                // alert('Producto no encontrado');
                notification({
                    type: 'error',
                    title: '&#10060; &nbsp; ERROR',
                    message: 'El producto no existe'
                });
            }
            else {
                // alert('Error desconocido, favor de comunicarse con el desarrollador');
                notification({
                    type: 'error',
                    title: '&#10060; &nbsp; ERROR',
                    message: 'Error desconocido, favor de comunicarse con el desarrollador'
                });
            }
        })
        .always(function () {
            frm.trigger("reset");
        });
});

let appendToObject = product => {
    if (product.barcode in products_list) {
        var quantity = products_list[product.barcode].quantity + 1;

        products_list[product.barcode] = {
            barcode: product.barcode,
            name: product.name,
            description: product.description,
            photo: product.photo,
            quantity: quantity,
            unitary_price: product.sale_price,
            total: product.sale_price * quantity
        };
    }
    else {
        products_list[product.barcode] = {
            barcode: product.barcode,
            name: product.name,
            description: product.description,
            photo: product.photo,
            quantity: 1,
            unitary_price: product.sale_price,
            total: product.sale_price
        };
    }
};

let displayToTable = () => {
    $('#products-list tbody').empty();
    let total = 0;
    let trs = '';

    $.each(products_list, function (index, product) {
        total += parseFloat(product.total);
        trs += `
            <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 text-sm">
                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Código de barras</span>
                    ${product.barcode}
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-left block lg:table-cell relative lg:static">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre del producto</span>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full" src="/storage/${product.photo}" alt="${product.name}">
                        </div>
                        <div class="ml-4 text-left">
                            <div class="text-sm font-medium text-gray-900">
                                ${product.name}
                            </div>
                            <div class="text-sm text-gray-500">
                                ${product.description}
                            </div>
                        </div>
                    </div>
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Cantidad</span>
                    <div class="flex justify-center" role="group">
                        <button class="decrement bg-white text-gray-500 hover:bg-red-500 hover:text-white border rounded-l-lg px-4 py-2 mx-0 outline-none focus:outline-none">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="text" name="quantity" value="${product.quantity}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="px-3 py-2 text-gray-700 relative bg-white text-sm border-t border-b outline-none w-16 text-center" readonly/>
                        <button class="increment bg-white text-gray-500 hover:bg-blue-500 hover:text-white border rounded-r-lg px-4 py-2 mx-0 outline-none focus:outline-none">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Precio unitario</span>
                    $${product.unitary_price}
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Total</span>
                    $${product.total}
                </td>
            </tr>
        `;
    });

    $('#products-list tbody').append(trs);
    $('#total-text').text(total);
};

$('#btn-cancel-sale').on('click', function () {
    $.confirm({
        title: 'Cancelar venta',
        content: '¿Esta seguro de cancelar esta venta?<br/><b>Esta acción no se puede deshacer</b>',
        type: 'red',
        typeAnimated: true,
        useBootstrap: false,
        boxWidth: '400px',
        buttons: {
            tryAgain: {
                text: 'Si, cancelar venta',
                action: function () {
                    products_list = {};
                    $('#products-list tbody').empty().append(`<tr><td colspan="5" class="bg-gray-100 uppercase text-xs py-10 border text-center text-gray-600">No hay productos en la lista</td></tr>`);
                    $('#total-text').text('0.00');
                    setTimeout(() => {
                        $('#barcode').trigger('focus');
                    }, 300);
                }
            },
            close: {
                text: 'No',
                btnClass: 'btn-red',
            }
        }
    });
});
/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/sales.js ***!
  \*******************************/
// let products_list = new Object();
// let sale = {
//     total: 0,
//     pago: 0,
//     cambio: 0
// };
// $('#frm-barcode').on('submit', function (e) {
//     e.preventDefault();
//     var frm = $(this);
//     if (frm.find('input').val().trim().length > 0) {
//         $.ajax({
//             url: frm.attr('action'),
//             method: frm.attr('method'),
//             data: {
//                 barcode: frm.find('input').val().trim()
//             },
//             dataType: 'json'
//         })
//             .done(function (response) {
//                 appendToObject(response);
//                 displayToTable();
//             })
//             .fail(function (jqXHR, textStatus, errorThrown) {
//                 var response = jqXHR.responseJSON;
//                 switch (jqXHR.status) {
//                     case 404:
//                         $.notifyBar({ cssClass: "error", html: response.message });
//                         break;
//                     case 406:
//                         $.notifyBar({ cssClass: "warning", html: response.message });
//                         break;
//                     default:
//                         $.notifyBar({ cssClass: "error", html: "Error desconocido, contactar al administrador del sistema!" });
//                         break;
//                 }
//             })
//             .always(function () {
//                 frm.trigger("reset");
//             });
//     }
// });
// $('#btn-cancel-sale').on('click', function () {
//     if (Object.keys(products_list).length === 0) return false;
//     $.confirm({
//         title: 'Cancelar venta',
//         content: '¿Esta seguro de cancelar esta venta?<br/><b>Esta acción no se puede deshacer</b>',
//         type: 'red',
//         typeAnimated: true,
//         useBootstrap: false,
//         boxWidth: '400px',
//         buttons: {
//             accept: {
//                 text: 'Si, cancelar venta',
//                 action: function () {
//                     clear();
//                 }
//             },
//             close: {
//                 text: 'No',
//                 btnClass: 'btn-red',
//             }
//         }
//     });
// });
// $('#btn-pay-sale').on('click', function (e) {
//     if (Object.keys(products_list).length === 0) return false;
//     $('#total').val(sale.total.toFixed(2));
//     openModal('modal-payment');
// });
// $('#btn-close-payment').on('click', function (e) {
//     $('#frm-payment').trigger('reset');
//     modalClose('modal-payment');
// });
// $('#pago').on('keyup', function () {
//     if ($(this).val().trim() !== '') {
//         let pago = Number($(this).val().trim());
//         sale.pago = isNaN(pago) ? 0 : parseFloat(pago);
//         sale.cambio = sale.pago - sale.total;
//         $('#cambio').val(sale.cambio.toFixed(2));
//     }
// });
// $('#btn-payment-sale').on('click', function (e) {
//     let btn = $(this);
//     let btnCancel = $('#btn-close-payment');
//     let frm = $("#frm-payment");
//     if (frm.valid()) {
//         btnCancel.prop('disabled', true);
//         btn.prop('disabled', true);
//         btnCancel.addClass('cursor-not-allowed');
//         btn.addClass('cursor-wait');
//         $.ajax({
//             url: frm.attr('action'),
//             method: 'POST',
//             dataType: 'json',
//             data: {
//                 sale: sale,
//                 products: products_list
//             }
//         })
//             .done(function (response) {
//                 products_list = new Object();
//                 sale = {
//                     total: 0,
//                     pago: 0,
//                     cambio: 0
//                 };
//                 frm.trigger('reset');
//                 modalClose('modal-payment');
//                 $('#products-list tbody').empty().append(`<tr><td colspan="6" class="bg-gray-100 uppercase text-sm py-10 border text-center text-gray-600">No hay productos en la lista</td></tr>`);
//                 $.notifyBar({ cssClass: "success", html: response.message });
//             })
//             .fail(function () {
//                 $.notifyBar({ cssClass: "error", html: "Error desconocido, contactar al administrador del sistema!" });
//             })
//             .always(function () {
//                 btnCancel.prop('disabled', false);
//                 btn.prop('disabled', false);
//                 btnCancel.removeClass('cursor-not-allowed');
//                 btn.removeClass('cursor-wait');
//             });
//     }
// });
// $('#frm-payment').validate({
//     rules: {
//         pago: {
//             required: true,
//             number: true,
//             min: function () {
//                 return parseFloat($("#total").val());
//             }
//         }
//     },
//     messages: {
//         pago: {
//             required: 'Ingrese la cantidad recibida',
//             number: 'Ingrese solo dígitos',
//             min: 'La cantidad recibida debe ser igual o mayor al total a pagar'
//         }
//     }
// });
// $('#btn-modal-products').on('click', function (e) {
//     openModal('modal-products');
//     $('#text').trigger('focus');
// });
// $('#btn-close-modal-products').on('click', function (e) {
//     modalClose('modal-products');
// });
$("#text").autocomplete({
  delay: 500,
  minLength: 2,
  source: function source(request, response) {
    $.ajax({
      url: $('#text').data('route'),
      method: 'POST',
      data: {
        text: request.term.trim()
      },
      dataType: "json"
    }).done(function (data) {
      response($.map(data, function (product) {
        var price = parseFloat(product.sale_price).toFixed(2);
        product.label = "".concat(product.name, " $").concat(price);
        return product;
      }));
    }).fail(function (jqXHR, textStatus, errorThrown) {
      var resp = jqXHR.responseJSON;
      response([{
        label: resp.message,
        notValid: true
      }]);
    });
  },
  select: function select(event, product) {
    if (!product.item.hasOwnProperty('notValid')) {
      appendToObject(product.item);
      displayToTable();
      $(this).val("");
      modalClose('modal-products');
      $('#barcode').trigger('focus');
      return false;
    }
  },
  open: function open(e, ui) {
    var acData = $(this).data('ui-autocomplete');
    acData.menu.element.find('li>div').each(function () {
      var me = $(this);
      var keywords = acData.term.split(' ').join('|');
      me.html(me.text().replace(new RegExp("(" + keywords + ")", "gi"), '<strong>$1</strong>'));
    });
  }
}); // let appendToObject = product => {
//     sale.total += parseFloat(product.sale_price);
//     if (product.barcode in products_list) {
//         var quantity = products_list[product.barcode].quantity + 1;
//         products_list[product.barcode] = {
//             quantity: quantity,
//             total: parseFloat(product.sale_price * quantity)
//         };
//     }
//     else {
//         products_list[product.barcode] = {
//             quantity: 1,
//             total: parseFloat(product.sale_price)
//         };
//     }
//     products_list[product.barcode].id = product.id;
//     products_list[product.barcode].barcode = product.barcode;
//     products_list[product.barcode].name = product.name;
//     products_list[product.barcode].description = product.description;
//     products_list[product.barcode].photo = product.photo;
//     products_list[product.barcode].stock = product.stock;
//     products_list[product.barcode].sale_price = parseFloat(product.sale_price);
//     products_list[product.barcode].unit_id = product.unit_id;
// };
// let displayToTable = () => {
//     $('#products-list tbody').empty();
//     $('#total-text').text(sale.total.toFixed(2));
//     let trs = '';
//     $.each(products_list, function (index, product) {
//         let readonly = (product.unit_id === 1) ? 'disabled="disabled"' : '';
//         let bg = (product.unit_id === 1) ? 'bg-gray-100' : 'bg-white';
//         trs += `
//             <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 text-sm">
//                 <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
//                     <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Código de barras</span>
//                     ${product.barcode}
//                 </td>
//                 <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-left block lg:table-cell relative lg:static">
//                     <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre del producto</span>
//                     <div class="flex items-center">
//                         <div class="flex-shrink-0 h-10 w-10">
//                             <img class="h-10 w-10 rounded-full" src="/storage/${product.photo}" alt="${product.name}">
//                         </div>
//                         <div class="ml-4 text-left">
//                             <div class="text-sm font-medium text-gray-900">
//                                 ${product.name}
//                             </div>
//                             <div class="text-sm text-gray-500">
//                                 ${product.description}
//                             </div>
//                         </div>
//                     </div>
//                 </td>
//                 <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
//                     <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Stock</span>
//                     <div class="flex justify-center" role="group">
//                         <button onclick="decrement(${product.barcode})" class="bg-white text-gray-500 hover:bg-red-500 hover:text-white border rounded-l-lg px-4 py-2 mx-0 outline-none focus:outline-none">
//                             <i class="fas fa-minus"></i>
//                         </button>
//                         <input onkeyup="calculate(this, '${product.barcode}')" value="${product.quantity}" type="text" name="quantity" class="px-3 py-2 text-gray-700 relative ${bg} text-sm w-16 text-center border-gray-200 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" ${readonly} />
//                         <button onclick="increment(${product.barcode})" class="bg-white text-gray-500 hover:bg-blue-500 hover:text-white border rounded-r-lg px-4 py-2 mx-0 outline-none focus:outline-none">
//                             <i class="fas fa-plus"></i>
//                         </button>
//                     </div>
//                 </td>
//                 <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
//                     <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Precio unitario</span>
//                     $${product.sale_price.toFixed(2)}
//                 </td>
//                 <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
//                     <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Total</span>
//                     $<span class="subtotal">${product.total.toFixed(2)}</span>
//                 </td>
//                 <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
//                     <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
//                     <button onclick="deleteProduct(this, ${product.barcode});" title="Eliminar" class="inline-block p-3 text-center text-white transition bg-red-500 rounded-full shadow ripple hover:shadow-lg hover:bg-red-600 focus:outline-none waves-effect">
//                         <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
//                             <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
//                         </svg>
//                     </button>
//                 </td>
//             </tr>
//         `;
//     });
//     $('#products-list tbody').append(trs);
// };
// increment = barcode => {
//     if (products_list[barcode].quantity < products_list[barcode].stock) {
//         products_list[barcode].quantity++;
//         products_list[barcode].total += products_list[barcode].sale_price;
//         sale.total += products_list[barcode].sale_price;
//         displayToTable();
//     }
//     else {
//         $.notifyBar({ cssClass: "warning", html: 'Haz alcanzado el stock del sistema' });
//     }
// };
// decrement = barcode => {
//     if (products_list[barcode].quantity > 1) {
//         products_list[barcode].quantity--;
//         products_list[barcode].total -= products_list[barcode].sale_price;
//         sale.total -= products_list[barcode].sale_price;
//         displayToTable();
//     }
// };
// deleteProduct = (button, barcode) => {
//     sale.total -= products_list[barcode].total;
//     $('#total-text').text(sale.total.toFixed(2));
//     delete products_list[barcode];
//     $(button).closest('tr').remove();
//     if (Object.keys(products_list).length === 0) {
//         $('#products-list tbody').empty().append(`<tr><td colspan="6" class="bg-gray-100 uppercase text-sm py-10 border text-center text-gray-600">No hay productos en la lista</td></tr>`);
//     }
// };
// clear = () => {
//     products_list = new Object();
//     sale = {
//         total: 0,
//         pago: 0,
//         cambio: 0
//     };
//     $('#total-text').text('0.00');
//     $('#products-list tbody').empty().append(`<tr><td colspan="6" class="bg-gray-100 uppercase text-sm py-10 border text-center text-gray-600">No hay productos en la lista</td></tr>`);
//     setTimeout(() => {
//         $('#barcode').trigger('focus');
//     }, 300);
// };
// calculate = (input, barcode) => {
// let value = input.value.trim();
// if (value === '') {
//     return false;
// }
// if(isNaN(value)) {
//     return false;
// }
// let sale_price = products_list[barcode].sale_price;
// let subtotal = sale_price * parseFloat(input.value);
// products_list[barcode].quantity = parseFloat(value);
// products_list[barcode].total = subtotal;
// // console.log(sale_price);
// // console.log(subtotal);
// console.log(subtotal);
// console.log(sale.total);
// sale.total = sale.total + subtotal;
// $('#total-text').text(sale.total.toFixed(2));
// $(input).closest('tr').find('.subtotal').text(subtotal.toFixed(2));
// };
/******/ })()
;
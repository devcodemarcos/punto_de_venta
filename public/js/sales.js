/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/sales.js ***!
  \*******************************/
var products_list = new Object();
var sale = new Object();
$('#frm-barcode').on('submit', function (e) {
  e.preventDefault();
  var frm = $(this);
  $.ajax({
    url: frm.attr('action'),
    method: frm.attr('method'),
    data: frm.serialize(),
    dataType: 'json'
  }).done(function (response) {
    appendToObject(response);
    displayToTable();
  }).fail(function (jqXHR, textStatus, errorThrown) {
    var response = jqXHR.responseJSON;

    switch (jqXHR.status) {
      case 404:
        $.notifyBar({
          cssClass: "error",
          html: response.message
        });
        break;

      case 406:
        $.notifyBar({
          cssClass: "warning",
          html: response.message
        });
        break;

      default:
        $.notifyBar({
          cssClass: "error",
          html: "Error desconocido, contactar al administrador del sistema!"
        });
        break;
    }
  }).always(function () {
    frm.trigger("reset");
  });
});

var appendToObject = function appendToObject(product) {
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
  } else {
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

var displayToTable = function displayToTable() {
  $('#products-list tbody').empty();
  var total = 0;
  var trs = '';
  $.each(products_list, function (index, product) {
    total += parseFloat(product.total);
    trs += "\n            <tr class=\"bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 text-sm\">\n                <td class=\"w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static\">\n                    <span class=\"lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase\">C\xF3digo de barras</span>\n                    ".concat(product.barcode, "\n                </td>\n                <td class=\"w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-left block lg:table-cell relative lg:static\">\n                    <span class=\"lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase\">Nombre del producto</span>\n                    <div class=\"flex items-center\">\n                        <div class=\"flex-shrink-0 h-10 w-10\">\n                            <img class=\"h-10 w-10 rounded-full\" src=\"/storage/").concat(product.photo, "\" alt=\"").concat(product.name, "\">\n                        </div>\n                        <div class=\"ml-4 text-left\">\n                            <div class=\"text-sm font-medium text-gray-900\">\n                                ").concat(product.name, "\n                            </div>\n                            <div class=\"text-sm text-gray-500\">\n                                ").concat(product.description, "\n                            </div>\n                        </div>\n                    </div>\n                </td>\n                <td class=\"w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static\">\n                    <span class=\"lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase\">Cantidad</span>\n                    <div class=\"flex justify-center\" role=\"group\">\n                        <button class=\"decrement bg-white text-gray-500 hover:bg-red-500 hover:text-white border rounded-l-lg px-4 py-2 mx-0 outline-none focus:outline-none\">\n                            <i class=\"fas fa-minus\"></i>\n                        </button>\n                        <input type=\"text\" name=\"quantity\" value=\"").concat(product.quantity, "\" oninput=\"this.value=this.value.replace(/[^0-9]/g,'');\" class=\"px-3 py-2 text-gray-700 relative bg-white text-sm border-t border-b outline-none w-16 text-center\" readonly/>\n                        <button class=\"increment bg-white text-gray-500 hover:bg-blue-500 hover:text-white border rounded-r-lg px-4 py-2 mx-0 outline-none focus:outline-none\">\n                            <i class=\"fas fa-plus\"></i>\n                        </button>\n                    </div>\n                </td>\n                <td class=\"w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static\">\n                    <span class=\"lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase\">Precio unitario</span>\n                    $").concat(product.unitary_price, "\n                </td>\n                <td class=\"w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static\">\n                    <span class=\"lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase\">Total</span>\n                    $").concat(product.total, "\n                </td>\n            </tr>\n        ");
  });
  $('#products-list tbody').append(trs);
  $('#total-text').text(total);
  sale.total = total;
};

$('#btn-cancel-sale').on('click', function () {
  if (Object.keys(products_list).length === 0) return false;
  $.confirm({
    title: 'Cancelar venta',
    content: '¿Esta seguro de cancelar esta venta?<br/><b>Esta acción no se puede deshacer</b>',
    type: 'red',
    typeAnimated: true,
    useBootstrap: false,
    boxWidth: '400px',
    buttons: {
      accept: {
        text: 'Si, cancelar venta',
        action: function action() {
          products_list = new Object();
          $('#products-list tbody').empty().append("<tr><td colspan=\"5\" class=\"bg-gray-100 uppercase text-xs py-10 border text-center text-gray-600\">No hay productos en la lista</td></tr>");
          $('#total-text').text('0.00');
          setTimeout(function () {
            $('#barcode').trigger('focus');
          }, 300);
        }
      },
      close: {
        text: 'No',
        btnClass: 'btn-red'
      }
    }
  });
});
$('#btn-pay-sale').on('click', function () {
  // if (Object.keys(products_list).length === 0) return false;
  $.confirm({
    title: 'Cobrar venta',
    type: 'blue',
    typeAnimated: true,
    useBootstrap: false,
    boxWidth: '500px',
    content: form(),
    buttons: {
      formSubmit: {
        text: 'Submit',
        btnClass: 'btn-blue',
        action: function action() {
          var name = this.$content.find('.name').val();

          if (!name) {
            $.alert('provide a valid name');
            return false;
          }

          $.alert('Your name is ' + name);
        }
      },
      cancel: function cancel() {//close
      }
    },
    onContentReady: function onContentReady() {
      var form = this;
      var total = sale.total;
      form.$content.find('#total_text').text(total.toFixed(2)); // this.buttons.formSubmit.disable();

      this.$content.find('#name').on('keyup', function (e) {
        var pago = parseFloat($(this).val()).toFixed(2);
        var cambio = pago - total;
        form.$content.find('#pago_text').text(pago);
        form.$content.find('#cambio_text').text(cambio.toFixed(2));
      });
    }
  });
});

var form = function form() {
  return "\n    <div class=\"w-full mt-2 px-0.5 mb-6\">\n        <label class=\"block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2\" for=\"name\">\n            Cantidad recibida\n        </label>\n        <div class=\"relative flex w-full flex-wrap items-stretch mb-3\">\n            <span class=\"z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2\">\n                <i class=\"fas fa-dollar-sign\"></i>\n            </span>\n            <input type=\"text\" name=\"name\" id=\"name\" class=\"px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10\" />\n        </div>\n        <div class=\"relative flex w-full flex-wrap items-stretch mb-3\">\n            <ul>\n                <li>Total: $<span id=\"total_text\">0.00</span></li>\n                <li>Pago: $<span id=\"pago_text\">0.00</span></li>\n                <li>Cambio: $<span id=\"cambio_text\">0.00</span></li>\n            </ul>\n        </div>\n    </div>\n    ";
};
/******/ })()
;
require('angular');

(function () {

    'use strict';

    let app = angular.module('myApp', [], [
        '$httpProvider',
        function ($httpProvider) {
            $httpProvider.defaults.headers.post['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
        }
    ]);

    app.directive('productssearchautocomplete', function () {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function ($scope, element, attrs, ngModelCtrl) {
                element.autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: $('#text').data('route'),
                            method: 'POST',
                            data: {
                                text: request.term.trim()
                            },
                            dataType: "json"
                        })
                            .done(function (data) {
                                response(
                                    $.map(data, function (product) {
                                        let price = product.sale_price;
                                        product.label = `${product.name} $${price}`;
                                        return product;
                                    })
                                );
                            })
                            .fail(function (jqXHR, textStatus, errorThrown) {
                                let resp = jqXHR.responseJSON;
                                response([{
                                    label: resp.message,
                                    notValid: true
                                }]);
                            });
                    },
                    select: function (event, product) {
                        if (!product.item.hasOwnProperty('notValid')) {
                            $scope.$apply(function () {
                                $scope.appendToObject(product.item);
                            });
                            $(this).val('');
                            $scope.close('modal-products');
                            $('#barcode').trigger('focus');
                            return false;
                        }
                    },
                    open: function (e, ui) {
                        let acData = $(this).data('ui-autocomplete');
                        acData.menu.element.find('li>div').each(function () {
                            let me = $(this);
                            let keywords = acData.term.split(' ').join('|');
                            me.html(me.text().replace(new RegExp("(" + keywords + ")", "gi"), '<strong>$1</strong>'));
                        });
                    }
                }, {
                    minLength: 2,
                    delay: 300
                });
            }
        }
    });

    app.controller('main', function ($scope, $http) {
        $scope.products = new Object();
        $scope.sale = {
            total: 0,
            cambio: 0,
            pago: ''
        };

        $scope.submit = function ($event) {
            $event.preventDefault();
            $http({
                method: 'POST',
                url: $('#frm-barcode').attr('action'),
                data: {
                    barcode: barcode
                }
            }).then(function successCallback(response) {
                try {
                    $scope.appendToObject(response.data);
                } catch (error) {
                    $.notifyBar({
                        cssClass: "warning",
                        html: error
                    });
                }
            }, function errorCallback(error) {
                switch (error.status) {
                    case 404:
                        $.notifyBar({
                            cssClass: "error",
                            html: error.data.message
                        });
                        break;
                    case 406:
                        $.notifyBar({
                            cssClass: "warning",
                            html: error.data.message
                        });
                        break;

                    default:
                        $.notifyBar({
                            cssClass: "error",
                            html: "Error desconocido, contactar al administrador del sistema!"
                        });
                        break;
                }
            });

            $scope.barcode = "";
        };
        $scope.paymentSale = function () {
            if ($('#frm-payment').valid()) {
                $.ajax({
                    url: $('#frm-payment').attr('action'),
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        sale: $scope.sale,
                        products: $scope.products
                    }
                })
                    .done(function (response) {
                        $scope.clear();
                        $scope.close('modal-payment');
                        $.notifyBar({
                            cssClass: "success",
                            html: response.message
                        });
                    })
                    .fail(function () {
                        $.notifyBar({
                            cssClass: "error",
                            html: "Error desconocido, contactar al administrador del sistema!"
                        });
                    });
            }
        };
        $scope.payment = function (value) {
            $scope.sale.cambio = value - $scope.sale.total;
        };
        $scope.calculate = function (evt, barcode) {
            $scope.products[barcode].quantity = parseFloat(evt.target.value);
            $scope.products[barcode].subtotal = $scope.products[barcode].sale_price * evt.target.value;
            $scope.getTotal();
        };
        $scope.openSale = function () {
            if ($scope.isObjectEmpty($scope.products)) {
                $.notifyBar({
                    cssClass: "error",
                    html: 'No hay una lista de productos por cobrar'
                });
                return false;
            }

            openModal('modal-payment');
            $('#pago').trigger('focus');
        };
        $scope.open = function (modal) {
            openModal(modal);
            $('#text').trigger('focus');
        };
        $scope.close = function (modal) {
            modalClose(modal);
            $('#barcode').trigger('focus');
        };
        $scope.increment = function (barcode) {
            if ($scope.products[barcode].quantity < $scope.products[barcode].stock) {
                $scope.products[barcode].quantity++;
                $scope.products[barcode].subtotal = $scope.products[barcode].sale_price * $scope.products[barcode].quantity;
                $scope.sale.total += parseFloat($scope.products[barcode].sale_price);
            } else {
                $.notifyBar({
                    cssClass: "warning",
                    html: 'Haz alcanzado el stock del sistema'
                });
            }
        };
        $scope.decrement = function (barcode) {
            if ($scope.products[barcode].quantity > 1) {
                $scope.products[barcode].quantity--;
                $scope.products[barcode].subtotal = $scope.products[barcode].sale_price * $scope.products[barcode].quantity;
                $scope.sale.total -= parseFloat($scope.products[barcode].sale_price);
            }
        };
        $scope.isObjectEmpty = function (products) {
            return Object.keys(products).length === 0;
        };
        $scope.cancelSale = function () {
            if ($scope.isObjectEmpty($scope.products)) {
                $.notifyBar({
                    cssClass: "error",
                    html: 'No hay una lista de productos por cancelar'
                });
                return false;
            }

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
                        action: function () {
                            $scope.clear();
                        }
                    },
                    close: {
                        text: 'No',
                        btnClass: 'btn-red',
                    }
                }
            });
        };
        $scope.clear = function () {
            $scope.$apply(function () {
                $scope.products = new Object();
                $scope.sale = {
                    total: 0,
                    cambio: 0,
                    pago: ''
                };
            });
        };
        $scope.deleteProduct = function (barcode) {
            $scope.sale.total -= $scope.products[barcode].subtotal;
            delete $scope.products[barcode];
            $('#barcode').trigger('focus');
        };
        $scope.appendToObject = function (product) {
            if (product.barcode in $scope.products) {
                if (product.stock <= $scope.products[product.barcode].quantity) {
                    throw 'Haz alcanzado el stock del sistema';
                }

                $scope.products[product.barcode].quantity++;
                $scope.products[product.barcode].subtotal = product.sale_price * $scope.products[product.barcode].quantity;
            } else {
                $scope.products[product.barcode] = {
                    quantity: 1,
                    subtotal: parseFloat(product.sale_price)
                };
            }

            $scope.products[product.barcode].id = product.id;
            $scope.products[product.barcode].barcode = product.barcode;
            $scope.products[product.barcode].name = product.name;
            $scope.products[product.barcode].description = product.description;
            $scope.products[product.barcode].photo = product.photo;
            $scope.products[product.barcode].stock = product.stock;
            $scope.products[product.barcode].sale_price = product.sale_price;
            $scope.products[product.barcode].unit_id = product.unit_id;

            $scope.sale.total += parseFloat(product.sale_price);
        };
        $scope.getTotal = function () {
            $scope.sale.total = 0;
            $.each($scope.products, function (index, product) {
                $scope.sale.total += product.subtotal;
            });
        };
    });

    $('#frm-payment').validate({
        rules: {
            pago: {
                required: true,
                number: true,
                min: function () {
                    return parseFloat($("#total").val());
                }
            }
        },
        messages: {
            pago: {
                required: 'Ingrese la cantidad recibida',
                number: 'Ingrese solo dígitos',
                min: 'La cantidad recibida debe ser igual o mayor al total a pagar'
            }
        }
    });

})();
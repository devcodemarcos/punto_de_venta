@extends('layouts.layout')

@push('css')
<link rel="stylesheet" href="{{ mix('css/plugins/jquery-ui.css') }}">
@endpush

@section('title', 'Ventas')
@section('content')

@php
$breads = [
    'Ventas' => '#'
];
@endphp

<x-breadcrumb :breads="$breads" />

<div class="w-full p-3" ng-app="myApp" ng-controller="main">
    <!--Table Card-->
    <div class="bg-white border rounded shadow">
        <div class="border-b p-3">
            <div class="font-bold uppercase flex justify-between">
                <h5 class="text-gray-600">Lista de productos a vender</h5>
                <span class="text-gray-600">Total $@{{ sale.total | number : 2 }}</span>
            </div>
        </div>
        <div class="p-5">
            <div class="items-center justify-between w-full flex pb-3 bg-white mb-2">
                <form ng-submit="submit($event)" id="frm-barcode" action="{{ route('sales.find.barcode') }}" method="POST" class="w-full" autocomplete="off">
                    <input ng-model="barcode" name="barcode" id="barcode" class="font-bold border-gray-300 uppercase rounded-full w-full pl-4 text-gray-500 bg-gray-100 leading-tight focus:outline-none outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 lg:text-sm text-xs" type="text" placeholder="Escanear código o escribir el código y presionar Enter" autofocus>
                </form>
                <button ng-click="open('modal-products')" class="bg-gray-200 border border-gray-300 p-2 hover:bg-blue-500 cursor-pointer mx-2 rounded-full">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <table class="border-collapse w-full" id="products-list">
                <thead>
                    <tr class="border-b-2 border-blue-800 bg-blue-500 text-xs font-semibold text-white">
                        <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Código de barras</th>
                        <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Nombre del producto</th>
                        <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Cantidad</th>
                        <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Precio unitario</th>
                        <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Subtotal</th>
                        <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="(index, product) in products" class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 text-sm">
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Código de barras</span>
                            @{{ product.barcode }}
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-left block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre del producto</span>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" ng-src="/storage/@{{ product.photo }}" alt="@{{ product.name }}">
                                </div>
                                <div class="ml-4 text-left">
                                    <div class="text-sm font-medium text-gray-900">
                                        @{{ product.name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @{{ product.description }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Stock</span>
                            <div class="flex justify-center" role="group">
                                <button ng-click="decrement(product.barcode)" class="bg-white text-gray-500 hover:bg-red-500 hover:text-white border rounded-l-lg px-4 py-2 mx-0 outline-none focus:outline-none">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input value="@{{ product.quantity }}" ng-keyup="calculate($event, product.barcode)" type="text" name="quantity" class="px-3 py-2 text-gray-700 relative text-sm w-20 text-center border-gray-200 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @{{ product.unit_id == 1 ? 'bg-gray-100' : 'bg-white' }}" ng-readonly="product.unit_id == 1" />
                                <button ng-click="increment(product.barcode)" class="bg-white text-gray-500 hover:bg-blue-500 hover:text-white border rounded-r-lg px-4 py-2 mx-0 outline-none focus:outline-none">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Precio unitario</span>
                            $@{{ product.sale_price | number : 2 }}
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Subtotal</span>
                            $@{{ product.subtotal | number : 2 }}
                        </td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
                            <button ng-click="deleteProduct(product.barcode)" title="Eliminar" class="tooltip inline-block p-3 text-center text-white transition bg-red-500 rounded-full shadow ripple hover:shadow-lg hover:bg-red-600 focus:outline-none waves-effect">
                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <tr ng-show="isObjectEmpty(products)">
                        <td colspan="6" class="bg-gray-100 uppercase text-sm py-10 border text-center text-gray-600">No hay productos en la lista</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-end">
            <div class="px-5 pt-1 pb-5">
                <div class="flex space-x-4">
                    <button type="button" ng-click="cancelSale()" class="w-32 bg-white tracking-wide text-gray-800 font-bold rounded border-b-2 border-red-400 hover:border-red-500 hover:bg-red-400 hover:text-white shadow-md py-2 px-6 inline-flex items-center float-right">
                        <span class="mx-auto">Cancelar</span>
                    </button>
                    <button type="button" ng-click="openSale()" class="w-32 bg-white tracking-wide text-gray-800 font-bold rounded border-b-2 border-blue-400 hover:border-blue-500 hover:bg-blue-400 hover:text-white shadow-md py-2 px-6 inline-flex items-center float-right">
                        <span class="mx-auto">Cobrar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--/table Card-->

    <div id="modal-payment" class="fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center animated faster hidden" style="background: rgba(0,0,0,.15);">
        <div class="border-t-8 border-blue-500 shadow-lg modal-container bg-white w-4/12 md:max-w-11/12 mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-2">
                    <p class="text-xl text-text-black font-semibold">Cobrar venta</p>
                </div>
                <div class="my-0.5 flex justify-center">
                    <form action="{{ route('sales.payment') }}" method="POST" id="frm-payment" class="w-full" autocomplete="off">
                        <div class="bg-white pt-4 pb-2 flex flex-col">
                            <div class="-mx-3 md:flex mb-2">
                                <div class="md:w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="barcode">
                                        Cantidad recibida
                                    </label>
                                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                        <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <input ng-keyup="payment(sale.pago)" ng-model="sale.pago" type="number" name="pago" id="pago" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" maxlength="8" />
                                    </div>
                                </div>
                            </div>
                            <div class="-mx-3 md:flex mb-2">
                                <div class="md:w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="barcode">
                                        Total a pagar
                                    </label>
                                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                        <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <input value="@{{ sale.total | number : 2 }}" type="text" name="total" id="total" class="cursor-not-allowed px-3 py-2 text-gray-500 relative bg-gray-100 rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="-mx-3 md:flex mb-2">
                                <div class="md:w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="barcode">
                                        Cambio a devolver
                                    </label>
                                    <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                        <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        <input value="@{{ sale.cambio | number : 2 }}" type="text" name="cambio" id="cambio" class="cursor-not-allowed px-3 py-2 text-gray-500 relative bg-gray-100 rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="flex justify-end pt-2 space-x-3">
                    <button type="button" ng-click="close('modal-payment')" class="px-4 bg-gray-200 px-2 py-1 uppercase rounded font-bold text-black hover:bg-gray-300">Cerrar</button>
                    <button type="button" ng-click="paymentSale()" class="px-4 bg-blue-500 px-2 py-1 uppercase rounded font-bold text-white hover:bg-blue-600">Terminar venta</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-products" class="fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center animated faster hidden" style="background: rgba(0,0,0,.15);">
        <div class="border-t-8 border-blue-500 shadow-lg modal-container bg-white w-4/12 md:max-w-11/12 mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-2">
                    <p class="text-xl text-text-black font-semibold">Buscar producto</p>
                </div>
                <div class="my-0.5 flex justify-center">
                    <div class="w-full bg-white pt-4 pb-2 flex flex-col">
                        <div class="-mx-3 md:flex mb-2">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="barcode">
                                    Buscar producto por nombre o descripción
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input productssearchautocomplete ng-model="text" data-route="{{ route('sales.find.text') }}" type="text" name="text" id="text" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pt-2 space-x-3">
                    <button ng-click="close('modal-products')" type="button" class="px-4 bg-gray-200 px-2 py-1 uppercase rounded font-bold text-black hover:bg-gray-300">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ mix('/js/sales-angular.js') }}"></script>
@endpush
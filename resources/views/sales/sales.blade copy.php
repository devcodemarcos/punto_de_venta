@extends('layouts.layout')

@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@section('title', 'Ventas')
@section('content')

@php
$breads = [
    'Ventas' => '#'
];
@endphp

<x-breadcrumb :breads="$breads" />

<div class="w-full p-3">
    <!--Table Card-->
    <div class="bg-white border rounded shadow">
        <div class="border-b p-3">
            <div class="font-bold uppercase flex justify-between">
                <h5 class="text-gray-600">Lista de productos a vender</h5>
                <span class="text-gray-600">Total $<span id="total-text">0.00</span></span>
            </div>
        </div>
        <div class="p-5">
            <div class="items-center justify-between w-full flex pb-3 bg-white mb-2">
                <form action="{{ route('sales.find.barcode') }}" method="POST" class="w-full" id="frm-barcode" autocomplete="off">
                    <input name="barcode" id="barcode" class="font-bold border-gray-300 uppercase rounded-full w-full pl-4 text-gray-500 bg-gray-100 leading-tight focus:outline-none outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 lg:text-sm text-xs" type="text" placeholder="Escanear código o escribir el código y presionar Enter" autofocus>
                </form>
                <button id="btn-modal-products" class="bg-gray-200 border border-gray-300 p-2 hover:bg-blue-500 cursor-pointer mx-2 rounded-full">
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
                        <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Total</th>
                        <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="bg-gray-100 uppercase text-sm py-10 border text-center text-gray-600">No hay productos en la lista</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-end">
            <div class="px-5 pt-1 pb-5">
                <div class="flex space-x-4">
                    <button type="button" id="btn-cancel-sale" class="w-32 bg-white tracking-wide text-gray-800 font-bold rounded border-b-2 border-red-400 hover:border-red-500 hover:bg-red-400 hover:text-white shadow-md py-2 px-6 inline-flex items-center float-right">
                        <span class="mx-auto">Cancelar</span>
                    </button>
                    <button type="button" id="btn-pay-sale" class="w-32 bg-white tracking-wide text-gray-800 font-bold rounded border-b-2 border-blue-400 hover:border-blue-500 hover:bg-blue-400 hover:text-white shadow-md py-2 px-6 inline-flex items-center float-right">
                        <span class="mx-auto">Cobrar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--/table Card-->
</div>


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
                                    <input type="text" name="pago" id="pago" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" maxlength="8" />
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
                                    <input value="0.00" type="text" name="total" id="total" class="cursor-not-allowed px-3 py-2 text-gray-500 relative bg-gray-100 rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" readonly />
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
                                    <input value="0.00" type="text" name="cambio" id="cambio" class="cursor-not-allowed px-3 py-2 text-gray-500 relative bg-gray-100 rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex justify-end pt-2 space-x-3">
                <button type="button" id="btn-payment-sale" class="px-4 bg-blue-500 px-2 py-1 uppercase rounded font-bold text-white hover:bg-blue-600">Terminar venta</button>
                <button type="button" id="btn-close-payment" class="px-4 bg-gray-200 px-2 py-1 uppercase rounded font-bold text-black hover:bg-gray-300">Cerrar</button>
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
                                <input data-route="{{ route('sales.find.text') }}" type="text" name="text" id="text" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-2 space-x-3">
                <button type="button" id="btn-close-modal-products" class="px-4 bg-gray-200 px-2 py-1 uppercase rounded font-bold text-black hover:bg-gray-300">Cerrar</button>
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ mix('/js/sales.js') }}"></script>
@endpush
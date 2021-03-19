@extends('layouts.layout')

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
            <!-- <h5 class="font-bold uppercase text-gray-600">Lista de productos a vender</h5> -->
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
                <button id="btnOpenModal" data-route="{{ route('sales.find.text') }}" class="bg-gray-200 border border-gray-300 p-2 hover:bg-blue-500 cursor-pointer mx-2 rounded-full">
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
                        <!-- <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell"></th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="bg-gray-100 uppercase text-xs py-10 border text-center text-gray-600">No hay productos en la lista</td>
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
@endsection

@push('scripts')
<!-- <script src="{{ asset('/js/plugins/typeahead.bundle.js') }}"></script> -->
<script src="{{ mix('/js/sales.js') }}"></script>
@endpush
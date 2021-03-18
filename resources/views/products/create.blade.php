@extends('layouts.layout')

@section('title', 'Registro de productos')
@section('content')

@php
$breads = [
    'Productos' => route('product.index'),
    'Registro' => '#'
];
@endphp

<x-breadcrumb :breads="$breads" />

<div class="flex flex-row flex-wrap flex-grow mt-2">
    <div class="w-full p-3">
        <!--Template Card-->
        <div class="bg-white border rounded shadow">
            <div class="border-b p-3">
                <h5 class="font-bold uppercase text-gray-500">Registro de productos</h5>
            </div>
            <div class="p-5">
                <form action="{{ route('product.store') }}" method="POST" id="frmProducts" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('POST')
                    <div class="bg-white px-8 pt-6 pb-8 flex flex-col">
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="barcode">
                                    Código de barras
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-barcode"></i>
                                    </span>
                                    <input type="text" name="barcode" id="barcode" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" autofocus />
                                </div>
                            </div>
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="name">
                                    Nombre
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                    <input type="text" name="name" id="name" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" />
                                </div>
                            </div>
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="description">
                                    Descripción
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                    <input type="text" name="description" id="description" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" />
                                </div>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="stock">
                                    Stock
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-hashtag"></i>
                                    </span>
                                    <input type="text" name="stock" id="stock" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" />
                                </div>
                            </div>
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="minimum_stock">
                                    Stock mínimo
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-hashtag"></i>
                                    </span>
                                    <input type="text" name="minimum_stock" id="minimum_stock" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" />
                                </div>
                            </div>
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="provider_id">
                                    Proveedor
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-shipping-fast"></i>
                                    </span>
                                    <select name="provider_id" id="provider_id" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10">
                                        @forelse ($providers as $provider)
                                            <option value="">-- Selecciona un proveedor --</option>
                                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                        @empty
                                            <option value="">-- No hay proveedores --</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="purchase_price">
                                    Precio de compra
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="text" name="purchase_price" id="purchase_price" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" />
                                </div>
                            </div>
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="sale_price">
                                    Precio de venta
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="text" name="sale_price" id="sale_price" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" />
                                </div>
                            </div>
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="photo">
                                    Imagen o foto del producto
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-images"></i>
                                    </span>
                                    <input type="file" name="photo" id="photo" class="px-3 py-1.5 text-gray-500 relative bg-white rounded text-sm border border-gray-300 w-full pl-10" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="m-3">
                            <button type="submit" class="w-32 bg-white tracking-wide text-gray-800 font-bold rounded border-b-2 border-blue-400 hover:border-blue-500 hover:bg-blue-400 hover:text-white shadow-md py-2 px-6 inline-flex items-center float-right">
                                <span class="mx-auto">Registrar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--/Template Card-->
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ mix('/js/products.js') }}"></script>
@endpush
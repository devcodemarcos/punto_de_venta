@extends('layouts.layout')

@section('title', 'Inicio')
@section('content')

@php
$breads = [
    'Inicio' => '#'
];
@endphp

<x-breadcrumb :breads="$breads" />

<div class="w-full p-3">
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3 mt-1 container-menu">
        <div class="rounded bg-white flex flex-col p-8 cursor-pointer shadow-lg hover:shadow-xl border-t-4 border-blue-500" data-route="{{ route('sales') }}">
            <div class="w-16 h-16 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5 flex-shrink-0 p-4">
                <i class="fas fa-hand-holding-usd fa-2x"></i>
            </div>
            <div class="flex-grow text-gray-500">
                <h2 class="text-xl title-font font-medium mb-3">Ventas</h2>
                <p class="leading-relaxed text-sm text-justify">
                    Aquí podras realizar la venta de todos tus productos &#128525;,
                    permitiendote realizar todas las operaciones básicas de una
                    venta de forma rápida &#9201;, eficiente y segura.
                </p>
            </div>
        </div>
        <div class="rounded bg-white flex flex-col p-8 cursor-pointer shadow-lg hover:shadow-xl border-t-4 border-blue-500" data-route="{{ route('product.index') }}">
            <div class="w-16 h-16 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5 flex-shrink-0 p-4">
                <i class="fas fa-gifts fa-2x"></i>
            </div>
            <div class="flex-grow text-gray-500">
                <h2 class="text-xl title-font font-medium mb-3">Productos</h2>
                <p class="leading-relaxed text-sm text-justify">
                    En este modulo podras llevar toda la administración de tus productos,
                </p>
            </div>
        </div>
        <div class="rounded bg-white flex flex-col p-8 cursor-pointer shadow-lg hover:shadow-xl border-t-4 border-blue-500" data-route="{{ route('provider.index') }}">
            <div class="w-16 h-16 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5 flex-shrink-0 p-4">
                <i class="fas fa-truck fa-2x"></i>
            </div>
            <div class="flex-grow text-gray-500">
                <h2 class="text-xl title-font font-medium mb-3">Proveedores</h2>
                <p class="leading-relaxed text-sm text-justify">
                    En este modulo podras llevar toda la administración de tus proveedores.
                </p>
            </div>
        </div>

        <div class="rounded bg-white flex flex-col p-8 cursor-pointer shadow-lg hover:shadow-xl border-t-4 border-blue-500" data-route="{{ route('user.index') }}">
            <div class="w-16 h-16 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5 flex-shrink-0 p-4">
                <i class="fas fa-users fa-2x"></i>
            </div>
            <div class="flex-grow text-gray-500">
                <h2 class="text-xl title-font font-medium mb-3">Usuarios</h2>
                <p class="leading-relaxed text-sm text-justify">
                    Aquí podras realizar la venta de todos tus productos 😍,
                    permitiendote realizar todas las operaciones básicas de una venta de forma rápida &#9201;, eficiente y segura.
                </p>
            </div>
        </div>
        <div class="rounded bg-white flex flex-col p-8 cursor-pointer shadow-lg hover:shadow-xl border-t-4 border-blue-500" data-route="#">
            <div class="w-16 h-16 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5 flex-shrink-0 p-4">
                <i class="fas fa-chart-line fa-2x"></i>
            </div>
            <div class="flex-grow text-gray-500">
                <h2 class="text-xl title-font font-medium mb-3">Reportes</h2>
                <p class="leading-relaxed text-sm text-justify">
                    Aquí podras realizar la venta de todos tus productos &#128525;,
                    permitiendote realizar todas las operaciones básicas de una
                    venta de forma rápida &#9201;, eficiente y segura.
                </p>
            </div>
        </div>
        <div class="rounded bg-white flex flex-col p-8 cursor-pointer shadow-lg hover:shadow-xl border-t-4 border-blue-500" data-route="#">
            <div class="w-16 h-16 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5 flex-shrink-0 p-4">
                <i class="fas fa-barcode fa-2x"></i>
            </div>
            <div class="flex-grow text-gray-500">
                <h2 class="text-xl title-font font-medium mb-3">Códigos de barra</h2>
                <p class="leading-relaxed text-sm text-justify">
                    En este modulo podras llevar toda la administración de tus productos,
                </p>
            </div>
        </div>

        <div class="rounded bg-white flex flex-col p-8 cursor-pointer shadow-lg hover:shadow-xl border-t-4 border-blue-500" data-route="#">
            <div class="w-16 h-16 inline-flex items-center justify-center rounded-full bg-blue-100 text-blue-500 mb-5 flex-shrink-0 p-4">
                <i class="fas fa-cog fa-2x fa-spin"></i>
            </div>
            <div class="flex-grow text-gray-500">
                <h2 class="text-xl title-font font-medium mb-3">Configuración</h2>
                <p class="leading-relaxed text-sm text-justify">
                    Aquí podras realizar la venta de todos tus productos 😍,
                    permitiendote realizar todas las operaciones básicas de una venta de forma rápida &#9201;, eficiente y segura.
                </p>
            </div>
        </div>

    </div>
</div>

@endsection
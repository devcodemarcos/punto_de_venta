@extends('layouts.layout')

@section('title', 'Registro de proveedores')
@section('content')

@php
$breads = [
    'Proveedores' => route('provider.index'),
    'Registro' => '#'
];
@endphp

<x-breadcrumb :breads="$breads" />

<div class="flex flex-row flex-wrap flex-grow mt-2">
    <div class="w-full p-3">
        <!--Template Card-->
        <div class="bg-white border rounded shadow">
            <div class="border-b p-3">
                <h5 class="font-bold uppercase text-gray-500">Registro de proveedores</h5>
            </div>
            <div class="p-5">
                <form action="{{ route('provider.store') }}" method="POST" id="frmProviders" autocomplete="off">
                    @csrf
                    @method('POST')
                    <div class="bg-white px-8 pt-6 pb-8 flex flex-col">
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="name">
                                    Nombre
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-pencil-alt"></i>
                                    </span>
                                    <input type="text" name="name" id="name" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" autofocus />
                                </div>
                            </div>
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="phone">
                                    Teléfono
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="text" name="phone" id="phone" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" />
                                </div>
                            </div>
                            <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="email">
                                    Correo Electrónico
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="text" name="email" id="email" class="px-3 py-2 text-gray-500 relative bg-white rounded text-sm border-gray-300 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full pl-10" />
                                </div>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="w-full px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="description">
                                    Comentarios
                                </label>
                                <div class="relative flex w-full flex-wrap items-stretch mb-3">
                                    <span class="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-2">
                                        <i class="fas fa-comments"></i>
                                    </span>
                                    <textarea name="comments" id="comments" class="text-gray-500 bg-white rounded text-sm border-gray-300 py-6 px-8 w-full border border-gray-200 relative resize-none outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
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
<script src="{{ mix('/js/providers.js') }}"></script>
@endpush
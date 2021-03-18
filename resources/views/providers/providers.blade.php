@extends('layouts.layout')

@section('title', 'Lista de proveedores')
@section('content')

@push('css')
    @livewireStyles
@endpush

@php
$breads = [
    'Proveedores' => '#'
];
@endphp

<x-breadcrumb :breads="$breads" />

<div class="w-full p-3">
    <div class="bg-white border rounded shadow">
        <livewire:providers/>
    </div>
</div>
@endsection

@push('livewire')
    @livewireScripts
@endpush

@push('scripts')
<script src="{{ mix('/js/providers.js') }}"></script>
@endpush
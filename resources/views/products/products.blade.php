@extends('layouts.layout')

@section('title', 'Lista de productos')
@section('content')

@push('css')
    @livewireStyles
@endpush

@php
$breads = [
    'Productos' => '#'
];
@endphp

<x-breadcrumb :breads="$breads" />

<div class="w-full p-3">
    <div class="bg-white border rounded shadow">
        <livewire:products/>
    </div>
</div>
@endsection

@push('livewire')
    @livewireScripts
@endpush

@push('scripts')
<script src="{{ mix('/js/products.js') }}"></script>
@endpush
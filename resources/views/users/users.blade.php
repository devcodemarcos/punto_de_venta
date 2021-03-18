@extends('layouts.layout')

@section('title', 'Lista de usuarios')
@section('content')

@push('css')
    @livewireStyles
@endpush

@php
$breads = [
    'Usuarios' => '#'
];
@endphp

<x-breadcrumb :breads="$breads" />

<div class="w-full p-3">
    <div class="bg-white border rounded shadow">
        <livewire:users></livewire:users>
    </div>
</div>
@endsection

@push('livewire')
    @livewireScripts
@endpush

@push('scripts')
<script src="{{ mix('/js/users.js') }}"></script>
@endpush
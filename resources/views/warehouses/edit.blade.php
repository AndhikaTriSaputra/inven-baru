@extends('layouts.app')

@section('header')
Edit Warehouse
@endsection

@section('content')
<form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST"
      class="bg-white border border-gray-200 rounded-lg p-6">
  @csrf
  @method('PUT')
  @include('warehouses._form')
</form>
@endsection

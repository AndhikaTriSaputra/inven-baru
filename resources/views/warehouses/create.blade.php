@extends('layouts.app')

@section('header')
Create Warehouse
@endsection

@section('content')
<form action="{{ route('warehouses.store') }}" method="POST"
      class="bg-white border border-gray-200 rounded-lg p-6">
  @csrf
  @include('warehouses._form')
</form>
@endsection

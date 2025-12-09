@extends('templates.layout')

@section('page-title', 'Order')

@section('content')
<div class="col-8">
  @include('order.form')
</div>
<div class="col-4">
  @include('order.cart')
</div>
@endsection

@push('scripts')
@include('order.script')
@endpush
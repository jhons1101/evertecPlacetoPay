@extends('welcome')

@section('content')
    <div class="row">
        <h1 class="mt-5">Products</h1>
    </div>
    <div class="row mt-4">
        @foreach ($products as $product)
        <div class="col-md-3">
            <div class="card" style="width: 18rem;">
                <img src="{{$product->url}}" class="card-img-top" alt="fragrance_1" height="300px">
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}} 1</h5>
                    <p class="card-text">$ {{$product->cost}} {{$product->currency}}</p>
                    <a href="/payment/{{$product->id}}" class="btn btn-primary">Payment</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
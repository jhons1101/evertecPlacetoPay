@extends('welcome')

@section('content')
    <h1 class="mt-5">Purchase order</h1>
    <br/>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($msg != "")
        <div class="alert alert-danger" role="alert">{{$msg}}</div>
    @endif
    <form name="frm" action="/payment" method="post">
        @csrf
        <input type="hidden" value="{{$idProduct}}" id="product_id" name="product_id">
        <div class="mb-3">
            <label for="nameUser" class="form-label">Name</label>
            <input type="text" class="form-control" id="nameUser" name="customer_name" value="{{old('customer_name')}}">
        </div>
        <div class="mb-3">
            <label for="emailUser" class="form-label">Email address</label>
            <input type="email" class="form-control" id="emailUser" aria-describedby="emailHelp" name="customer_email" value="{{old('customer_email')}}">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="phoneUser" class="form-label">Phone</label>
            <input type="number" class="form-control" id="phoneCustomer" name="customer_phone" value="{{old('customer_phone')}}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
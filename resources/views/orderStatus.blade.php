@extends('welcome')

@section('content')
    <h1 class="mt-5">Order Status</h1>
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
    <form name="form" action="/getStatus" method="get">
        @csrf
        <div class="row mt-2">
            <div class="col-md-4">
                <input type="number" class="form-control" name="payReference" placeholder="Payment Reference">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <hr>
    @if($arrStatus)
        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">Payment reference</th>
                    <th scope="col">Purchase order</th>
                    <th scope="col">Amount paid</th>
                    <th scope="col">Status</th>
                    <th scope="col">Payment method</th>
                    @if($arrStatus['statusOrder'] != 'APPROVED')
                    <th scope="col">&nbsp;</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">{{$arrStatus['requestId']}}</th>
                    <th scope="row">{{$arrStatus['paymentReference']}}</th>
                    <td>{{$arrStatus['amountPaid']}} {{$arrStatus['currencyPaid']}}</td>
                    <td>{{$arrStatus['statusOrder']}}</td>
                    <td>{{$arrStatus['paymentMethod']}}</td>
                    @if($arrStatus['statusOrder'] != 'APPROVED')
                    <td>
                        <a href="/paymentAgain/{{$arrStatus['paymentReference']}}" >
                            <button type="button" class="btn btn-warning">Payment</button>
                        </a>
                    </td>
                    @endif
                </tr>
            </tbody>
        </table>
    @endif
@endsection
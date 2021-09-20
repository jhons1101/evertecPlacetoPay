@extends('welcome')

@section('content')
    <h1 class="mt-5">List Orders</h1>
    @if($arrOrders)
        <table class="table mt-5 table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Purchase order</th>
                    <th scope="col">Product</th>
                    <th scope="col">Customer name</th>
                    <th scope="col">Amount paid</th>
                    <th scope="col">Status</th>
                    <th scope="col">Updated at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($arrOrders as $order)
                <tr>
                    <th scope="row">{{ $order->id }}</th>
                    <th scope="row">{{ $order->id_product }} - {{ $order->name }}</th>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->cost }} {{ $order->currency }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No records to show</p>
    @endif
@endsection
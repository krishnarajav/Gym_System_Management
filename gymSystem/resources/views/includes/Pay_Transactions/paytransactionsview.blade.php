@extends('homepage')
@section('title', 'Pay Transactions View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Pay Transactions</h1>
        <a class="add-button" href="{{route('paytransactionform')}}">
            <button class="add-btn">Add</button>
        </a>
        <form class="search-bar">
            <input type="search" placeholder="Search" aria-label="Search">
            <button type="submit">Search</button>
        </form>
        <div class="sep"></div>
    </div>    
    <table class="customers-table">
        <thead>
            <tr>
                <th>Payer ID</th>
                <th>Payee ID</th>
                <th>Payment Mode</th>
                <th>Paid Date</th>
                <th>Amount</th>
                <th>Transaction ID</th>
            </tr>
        </thead>
    <!--
        <tbody>
        {{--    @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->c_id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->dob }}</td>
                    <td>{{ $customer->age }}</td>
                    <td>{{ $customer->gender }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->mobile }}</td>
                    <td>{{ $customer->p_id }}</td>
                    <td>{{ $customer->p_start }}</td>
                    <td>{{ $customer->p_end }}</td>
                </tr>
            @endforeach
        --}}
        </tbody>
    -->
    </table>
</div>
@endsection
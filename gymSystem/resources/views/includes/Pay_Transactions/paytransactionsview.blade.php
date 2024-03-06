@extends('homepage')
@section('title', 'Pay Transactions View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Pay Transactions</h1>
        <a class="add-button" href="{{route('paytransactionform')}}">
            <button class="add-btn">Add</button>
        </a>
        <!--        <form class="search-bar">
            <input type="search" placeholder="Search" aria-label="Search">
            <button type="submit">Search</button>
        </form>-->
        <div class="sep"></div>
    </div>    
    <div class="table-container">
        <table class="display-table">
            <thead>
                <tr style="height: 50px;">
                    <th>Payer ID</th>
                    <th>Payee ID</th>
                    <th>Payment Mode</th>
                    <th>Payment Date</th>
                    <th>Amount (INR)</th>
                    <th>Transaction ID</th>
                    <th style="width: 60px;">Delete</th>
                </tr>
            </thead>
    
            <tbody>
                @if(isset($paytransactions) && count($paytransactions) > 0)
                    @foreach($paytransactions as $paytransaction)
                        <tr style="height: 60px;">
                            <td>{{ $paytransaction->payer_id }}</td>
                            <td>{{ $paytransaction->payee_id}}</td>
                            <td>{{ $paytransaction->payment_mode}}</td>
                            <td>{{ \Carbon\Carbon::parse($paytransaction->pay_date)->format('d-m-Y') }}</td>
                            <td>{{ $paytransaction->amount}}</td>
                            <td>{{ $paytransaction->transaction_id}}</td>
                            <td>
                                <div class="delete-button">
                                    <form action="{{ route('deletepaytransaction', $paytransaction->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this paytransaction?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach 
                @else
                    <tr>
                        <td colspan="13">No entries available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
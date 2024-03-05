@extends('homepage')
@section('title', 'Pay Transaction Details Form')
@section('content')
<div class="detailsform">
    <form action="{{route('storepaytransaction')}}" method="POST" autocomplete="off">
        @csrf

        <h1>Pay Transaction Details Form</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label style="width: 110px;" for="payer_id">Payer ID:</label>
            <input type="text" id="payer_id" name="payer_id" required>
            <br>

            <label style="width: 110px;" for="payee_id">Payee ID:</label>
            <input type="text" id="payee_id" name="payee_id" required>
            <br>

            <label style="width: 110px;" for="payment_mode">Payment Mode:</label>
            <select id="payment_mode" name="payment_mode" required>
                <option value="upi">UPI Transaction</option>
                <option value="cash">Cash</option>
                <option value="other">Other</option>
            </select>
            <br>

            <label style="width: 110px;" for="pay_date">Paid Date:</label>
            <input style="width: 150px;" type="date" id="pay_date" name="pay_date" required>
            <br>

            <label style="width: 110px;" for="amount">Amount (INR):</label>
            <input type="amount" step="0.01" id="amount" name="amount" required>
            <br>
    
            <label style="width: 110px;" for="transaction_id">Transaction ID:</label>
            <input type="text" id="transaction_id" name="transaction_id" required>
            <br><br>
    
            <div class="button-group">
                <a class="cancel-button" href="{{route('paytransactions')}}">Cancel</a>
                <button type="submit">Submit</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

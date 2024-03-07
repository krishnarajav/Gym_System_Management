@extends('homepage')
@section('title', 'Plan Details Form')
@section('content')
<div class="detailsform">
    <form action="{{ route('storeplan') }}" method="POST" autocomplete="off">
        @csrf

        <h1>Plan Details Form</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label for="p_id">Plan ID:</label>
            <input type="text" id="p_id" name="p_id" value="{{ $p_id }}" readonly required>
            <br>
    
            <label for="name">Name:</label>
            <input style="width: 280px;" type="text" id="name" name="name" required>
            <br>

            <label for="period">Period:</label>
            <select style="width: 180px;" id="period" name="period" required>
                <option value="28">1 Month (28 days)</option>
                <option value="84">3 Months (84 days)</option>
                <option value="168">6 Months (168 days)</option>
            </select>
            <br>
    
            <label for="price">Price (INR):</label>
            <input type="number" step="0.01" id="price" name="price" required>
            <br><br>

            <div style="color: rgb(233, 5, 5);">
                @if($errors->any())
                    <div class="error-message">Validation errors occurred. Please enter the correct details.</div>
                @endif
            </div>
            <br>
    
            <div class="button-group">
                <a class="cancel-button" href="{{ route('plans') }}">Cancel</a>
                <button type="submit">Submit</button>
            </div>
        </div>
        
    </form>
</div>
@endsection
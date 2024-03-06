@extends('homepage')
@section('title', 'Edit Plan Details')
@section('content')
<div class="detailsform">
    <form action="{{ route('updateplan', $plan->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <h1>Edit Plan Details</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label for="p_id">Plan ID:</label>
            <input type="text" id="p_id" name="p_id" value="{{ $plan->p_id }}" readonly required>
            <br>
    
            <label for="name">Name:</label>
            <input style="width: 280px;" type="text" id="name" name="name" value="{{ $plan->name }}" required>
            <br>

            <label for="period">Period:</label>
            <select style="width: 180px;" id="period" name="period" required>
                <option value="28" {{ $plan->period === 28 ? 'selected' : '' }}>1 Month (28 days)</option>
                <option value="84" {{ $plan->period === 84 ? 'selected' : '' }}>3 Months (84 days)</option>
                <option value="168" {{ $plan->period === 168 ? 'selected' : '' }}>6 Months (168 days)</option>
            </select>
            <br>
    
            <label for="price">Price (INR):</label>
            <input type="number" step="0.01" id="price" name="price" value="{{ $plan->price }}" required>
            <br><br>
            
            <div style="color: rgb(233, 5, 5);">
                @if($errors->any())
                    <div class="error-message">Validation errors occurred. Please check the form.</div>
                @endif
            </div>

            <br> 

            <div class="button-group">
                <a class="cancel-button" href="{{ route('plans') }}">Cancel</a>
                <button type="submit">Update</button>
            </div>
        </div>
        
    </form>
</div>
@endsection
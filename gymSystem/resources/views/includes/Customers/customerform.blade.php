@extends('homepage')
@section('title', 'Customer Details Form')
@section('content')
<div class="detailsform">
    <form action="{{route('storecustomer')}}" method="POST" autocomplete="off">
        @csrf

        <h1>Customer Details Form</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label for="c_id">Customer ID:</label>
            <input type="text" id="c_id" name="c_id" value="{{ $c_id }}" readonly required>
            <br>
    
            <label for="name">Name:</label>
            <input style="width: 280px;" type="text" id="name" name="name" required>
            <br>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <label for="dob">Date of Birth:</label>
            <input style="width: 150px;" type="date" id="dob" name="dob" required>
            <br>

            <script>
                $(document).ready(function () {
                    var today = new Date().toISOString().split('T')[0];
                    $("#dob").attr('max', today);
                });
            </script>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <br>

            <label for="height">Height (cm):</label>
            <input style="width: 150px;" type="number" min="0" id="height" name="height" required>
            <br>

            <label for="weight">Weight (kg):</label>
            <input style="width: 150px;" type="number" min="0" id="weight" name="weight" required>
            <br>
    
            <label for="address">Address:</label>
            <input style="width: 800px;" type="text" id="address" name="address" required>
            <br>
    
            <label for="mobile">Mobile:</label>
            <input type="tel" id="mobile" name="mobile" required>
            <br>
    
            
            <label for="p_id">Plan ID:</label>
            <select id="p_id" name="p_id" required>
                
                @foreach($plans as $plan)
                    <option value="{{ $plan->p_id }}">{{ $plan->p_id }}</option>
                @endforeach
            </select>
            <br>
    
            <label for="p_start">Plan Start:</label>
            <input style="width: 150px;" type="date" id="p_start" name="p_start" required>
            <br>
            
            <div style="color: rgb(233, 5, 5);">
                @if($errors->any())
                    <div class="error-message">Validation errors occurred. Please enter the correct details.</div>
                @endif
            </div>

            <br> 

            <div class="button-group">
                <a class="cancel-button" href="{{route('customers')}}">Cancel</a>
                <button type="submit">Submit</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

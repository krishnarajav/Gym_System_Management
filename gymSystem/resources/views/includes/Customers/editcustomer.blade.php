@extends('homepage')
@section('title', 'Edit Customer Details')
@section('content')
<div class="detailsform">
    <form action="{{ route('updatecustomer', $customer->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <h1>Edit Customer Details</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label for="c_id">Customer ID:</label>
            <input type="text" id="c_id" name="c_id" value="{{ $customer->c_id }}" readonly required>
            <br>

            <label for="name">Name:</label>
            <input style="width: 280px;" type="text" id="name" name="name" value="{{ $customer->name }}" required>
            <br>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <label for="dob">Date of Birth:</label>
            <input style="width: 150px;" type="date" id="dob" name="dob" value="{{ $customer->dob }}" required>
            <br>

            <script>
                $(document).ready(function () {
                    var today = new Date().toISOString().split('T')[0];
                    $("#dob").attr('max', today);
                });
            </script>

            <label for="age">Age:</label>
            <input style="width: 150px;" type="number" id="age" name="age" value="{{ $customer->age }}" readonly>
            <br>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" {{ $customer->gender === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $customer->gender === 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ $customer->gender === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <br>

            <label for="address">Address:</label>
            <input style="width: 600px;" type="text" id="address" name="address" value="{{ $customer->address }}" required>
            <br>

            <label for="mobile">Mobile:</label>
            <input type="tel" id="mobile" name="mobile" value="{{ $customer->mobile }}" required>
            <br>

            <label for="joined">Date Joined:</label>
            <input style="width: 150px;" type="date" id="joined" name="created_at" value="{{ $customer->created_at->format('Y-m-d') }}" readonly>
            <br>

            <label for="p_id">Plan ID:</label>
            <select id="p_id" name="p_id" required>
                @foreach($plans as $plan)
                    <option value="{{ $plan->p_id }}" {{ $customer->p_id == $plan->p_id ? 'selected' : '' }}>{{ $plan->p_id }}</option>
                @endforeach
            </select>
            <br>

            <label for="p_start">Plan Start:</label>
            <input style="width: 150px;" type="date" id="p_start" name="p_start" value="{{ $customer->p_start }}" required>
            <br>

            <label for="p_end">Plan End:</label>
            <input style="width: 150px;" type="date" id="p_end" name="p_end" value="{{ $customer->p_end }}" readonly>
            <br>
            
            <div style="color: rgb(233, 5, 5);">
                @if($errors->any())
                    <div class="error-message">Validation errors occurred. Please enter the correct details.</div>
                @endif
            </div>
            <br> 

            <div class="button-group">
                <a class="cancel-button" href="{{ route('customers') }}">Cancel</a>
                <button type="submit">Update</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

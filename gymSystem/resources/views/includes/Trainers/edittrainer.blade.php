@extends('homepage')
@section('title', 'Trainer Details')
@section('content')
<div class="detailsform">
    <form action="{{ route('updatetrainer', $trainer->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <h1>Trainer Details</h1>
        <div class="sep"></div>

        <div class="entryform">
            <p style="font-style: italic; color: #aaa;">Last updated at: {{ \Carbon\Carbon::parse($trainer->updated_at)->format('d-m-Y h:i:s A') }}</p>
            <br>

            <label style="width: 140px;" for="t_id">Trainer ID:</label>
            <input type="text" id="t_id" name="t_id" value="{{ $trainer->t_id }}" readonly required>
            <br>

            <label style="width: 140px;" for="name">Name:</label>
            <input style="width: 280px;" type="text" id="name" name="name" value="{{ $trainer->name }}" required>
            <br>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <label style="width: 140px;" for="dob">Date of Birth:</label>
            <input style="width: 150px;" type="date" id="dob" name="dob" value="{{ $trainer->dob }}" required>
            <br>

            <script>
                $(document).ready(function () {
                    var today = new Date().toISOString().split('T')[0];
                    $("#dob").attr('max', today);
                });
            </script>

            <label style="width: 140px;" for="age">Age:</label>
            <input style="width: 150px;" type="number" id="age" name="age" value="{{ $trainer->age }}" readonly>
            <br>

            <label style="width: 140px;" for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" {{ $trainer->gender === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $trainer->gender === 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ $trainer->gender === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <br>

            <label style="width: 140px;" for="height">Height (cm):</label>
            <input style="width: 150px;" type="number" min="0" id="height" name="height" value="{{ $trainer->height }}" required>
            <br>

            <label style="width: 140px;" for="weight">Weight (kg):</label>
            <input style="width: 150px;" type="number" min="0" id="weight" name="weight" value="{{ $trainer->weight }}" required>
            <br>

            <label style="width: 140px;" for="address">Address:</label>
            <input style="width: 600px;" type="text" id="address" name="address" value="{{ $trainer->address }}" required>
            <br>

            <label style="width: 140px;" for="mobile">Mobile:</label>
            <input type="tel" id="mobile" name="mobile" value="{{ $trainer->mobile }}" required>
            <br>

            <label style="width: 140px;" for="experience">Experience (Years):</label>
            <input style="width: 150px;" type="number" min="0" id="experience" name="experience" value="{{ $trainer->experience }}" required>
            <br>

            <label style="width: 140px;" for="joined">Date Joined:</label>
            <input style="width: 150px;" type="date" id="joined" name="created_at" value="{{ \Carbon\Carbon::parse($trainer->created_at)->toDateString() }}" readonly>
            <br>

            <label style="width: 140px;" for="salary">Monthly Salary (INR):</label>
            <input style="width: 150px;" type="number" min="0" id="salary" name="salary" value="{{ $trainer->salary }}" required>
            <br>
            
            <div style="color: rgb(233, 5, 5);">
                @if($errors->any())
                    <div class="error-message">Validation errors occurred. Please enter the correct details.</div>
                @endif
            </div>
            <br> 

            <div class="button-group">
                <a class="cancel-button" href="{{ route('trainers') }}">Back</a>
                <button type="submit">Update</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

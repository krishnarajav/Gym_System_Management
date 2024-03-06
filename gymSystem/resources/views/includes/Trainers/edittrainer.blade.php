@extends('homepage')
@section('title', 'Edit Trainer Details')
@section('content')
<div class="detailsform">
    <form action="{{ route('updatetrainer', $trainer->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <h1>Edit Trainer Details</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label for="t_id">Trainer ID:</label>
            <input type="text" id="t_id" name="t_id" value="{{ $trainer->t_id }}" readonly required>
            <br>

            <label for="name">Name:</label>
            <input style="width: 280px;" type="text" id="name" name="name" value="{{ $trainer->name }}" required>
            <br>

            <label for="dob">Date of Birth:</label>
            <input style="width: 150px;" type="date" id="dob" name="dob" value="{{ $trainer->dob }}" required>
            <br>

            <label for="age">Age:</label>
            <input style="width: 150px;" type="number" id="age" name="age" value="{{ $trainer->age }}" readonly>
            <br>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" {{ $trainer->gender === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $trainer->gender === 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ $trainer->gender === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <br>

            <label for="address">Address:</label>
            <input style="width: 600px;" type="text" id="address" name="address" value="{{ $trainer->address }}" required>
            <br>

            <label for="mobile">Mobile:</label>
            <input type="tel" id="mobile" name="mobile" value="{{ $trainer->mobile }}" required>
            <br>

            <label for="experience">Experience:</label>
            <input style="width: 150px;" type="number" id="experience" name="experience" value="{{ $trainer->experience }}" required>
            <br>

            <label for="joined">Date Joined:</label>
            <input style="width: 150px;" type="date" id="joined" name="created_at" value="{{ $trainer->created_at->format('Y-m-d') }}" readonly>
            <br>

            <label for="salary">Monthly Salary (INR):</label>
            <input style="width: 150px;" type="number" id="salary" name="salary" value="{{ $trainer->salary }}" required>
            <br>
            
            <div style="color: rgb(233, 5, 5);">
                @if($errors->any())
                    <div class="error-message">Validation errors occurred. Please check the form.</div>
                @endif
            </div>
            <br> 

            <div class="button-group">
                <a class="cancel-button" href="{{ route('trainers') }}">Cancel</a>
                <button type="submit">Update</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

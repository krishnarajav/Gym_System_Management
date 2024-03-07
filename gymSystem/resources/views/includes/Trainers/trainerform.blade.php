@extends('homepage')
@section('title', 'Trainer Details Form')
@section('content')
<div class="detailsform">
    <form action="{{route('storetrainer')}}" method="POST" autocomplete="off">
        @csrf

        <h1>Trainer Details Form</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label style="width: 140px;" for="t_id">Trainer ID:</label>
            <input type="text" id="t_id" name="t_id" value="{{ $t_id }}" readonly required>
            <br>
    
            <label style="width: 140px;" for="name">Name:</label>
            <input style="width: 280px;" type="text" id="name" name="name" required>
            <br>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <label style="width: 140px;" for="dob">Date of Birth:</label>
            <input style="width: 150px;" type="date" id="dob" name="dob" required>
            <br>

            <script>
                $(document).ready(function () {
                    var today = new Date().toISOString().split('T')[0];
                    $("#dob").attr('max', today);
                });
            </script>

            <label style="width: 140px;" for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <br>    
    
            <label style="width: 140px;" for="address">Address:</label>
            <input style="width: 800px;" type="text" id="address" name="address" required>
            <br>
    
            <label style="width: 140px;" for="mobile">Mobile:</label>
            <input type="tel" id="mobile" name="mobile" required>
            <br>

            <label style="width: 140px;" for="salary">Experience (Years):</label>
            <input type="number" id="experience" name="experience" required>
            <br>
            
            <label style="width: 140px;" for="salary">Monthly Salary (INR):</label>
            <input type="number" step="0.01" id="salary" name="salary" required>
            <br><br>

            <div style="color: rgb(233, 5, 5);">
                @if($errors->any())
                    <div class="error-message">Validation errors occurred. Please enter the correct details.</div>
                @endif
            </div>
            <br>
    
            <div class="button-group">
                <a class="cancel-button" href="{{route('trainers')}}">Cancel</a>
                <button type="submit">Submit</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

@extends('homepage')
@section('title', 'Session Details Form')
@section('content')
<div class="detailsform">
    <form action="{{route('storesession')}}" method="POST" autocomplete="off">
        @csrf

        <h1>Session Details Form</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label for="s_date">Date:</label>
            <input type="date" id="s_date" name="s_date" required>
            <br>
    
            <label for="s_time">Time:</label>
            <select style="width: 180px;" id="s_time" name="s_time" required>
                <option value="06:00 AM - 07:00 AM">06:00 AM - 07:00 AM</option>
                <option value="06:00 AM - 08:00 AM">06:00 AM - 08:00 AM</option>
                <option value="07:00 AM - 08:00 AM">07:00 AM - 08:00 AM</option>
                <option value="07:00 AM - 09:00 AM">07:00 AM - 09:00 AM</option>
                <option value="08:00 AM - 09:00 AM">08:00 AM - 09:00 AM</option>
                <option value="08:00 AM - 10:00 AM">08:00 AM - 10:00 AM</option>
                <option value="09:00 AM - 10:00 AM">09:00 AM - 10:00 AM</option>
                <option value="01:00 PM - 02:00 PM">01:00 PM - 02:00 PM</option>
                <option value="01:00 PM - 03:00 PM">01:00 PM - 03:00 PM</option>
                <option value="05:00 PM - 06:00 PM">05:00 PM - 06:00 PM</option>
                <option value="05:00 PM - 07:00 PM">05:00 PM - 07:00 PM</option>
                <option value="06:00 PM - 07:00 PM">06:00 PM - 07:00 PM</option>
                <option value="06:00 PM - 08:00 PM">06:00 PM - 08:00 PM</option>
                <option value="07:00 PM - 08:00 PM">07:00 PM - 08:00 PM</option>
                <option value="07:00 PM - 09:00 PM">07:00 PM - 09:00 PM</option>
                <option value="08:00 PM - 09:00 PM">08:00 PM - 09:00 PM</option>
            </select>
            <br>
    
            <label for="c_id">Customer ID:</label>
            <input type="text" id="c_id" name="c_id" required>
            <br>

            <label for="t_id">Trainer ID:</label>
            <input type="text" id="t_id" name="t_id">
            <br>

            @if($errors->has('c_id') && $errors->has('t_id'))
                <div class="error-message">Both Customer ID and Trainer ID are not available in the database.</div>
            @elseif($errors->has('c_id'))
                <div class="error-message">{{ $errors->first('c_id') }}</div>
            @elseif($errors->has('t_id'))
                <div class="error-message">{{ $errors->first('t_id') }}</div>
            @endif
            <br>
    
            <div class="button-group">
                <a class="cancel-button" href="{{route('sessions')}}">Cancel</a>
                <button type="submit">Submit</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

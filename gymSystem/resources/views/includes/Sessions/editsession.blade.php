@extends('homepage')
@section('title', 'Session Details')
@section('content')
<div class="detailsform">
    <form action="{{ route('updatesession', $gsession->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <h1>Session Details</h1>
        <div class="sep"></div>

        <div class="entryform">
            <p style="font-style: italic; color: #aaa;">Last updated at: {{ \Carbon\Carbon::parse($gsession->updated_at)->format('d-m-Y h:i:s A') }}</p>
            <br>

            <label for="s_date">Date:</label>
            <input style="width: 150px;" type="date" id="s_date" name="s_date" value="{{ $gsession->s_date }}" required>
            <br>

            <label for="s_time">Time:</label>
            <select style="width: 180px;" id="s_time" name="s_time" required>
                <option value="06:00 AM - 07:00 AM" {{ $gsession->s_time === "06:00 AM - 07:00 AM" ? 'selected' : '' }}>06:00 AM - 07:00 AM</option>
                <option value="06:00 AM - 08:00 AM" {{ $gsession->s_time === "06:00 AM - 08:00 AM" ? 'selected' : '' }}>06:00 AM - 08:00 AM</option>
                <option value="07:00 AM - 08:00 AM" {{ $gsession->s_time === "07:00 AM - 08:00 AM" ? 'selected' : '' }}>07:00 AM - 08:00 AM</option>
                <option value="07:00 AM - 09:00 AM" {{ $gsession->s_time === "07:00 AM - 09:00 AM" ? 'selected' : '' }}>07:00 AM - 09:00 AM</option>
                <option value="08:00 AM - 09:00 AM" {{ $gsession->s_time === "08:00 AM - 09:00 AM" ? 'selected' : '' }}>08:00 AM - 09:00 AM</option>
                <option value="08:00 AM - 10:00 AM" {{ $gsession->s_time === "08:00 AM - 10:00 AM" ? 'selected' : '' }}>08:00 AM - 10:00 AM</option>
                <option value="09:00 AM - 10:00 AM" {{ $gsession->s_time === "09:00 AM - 10:00 AM" ? 'selected' : '' }}>09:00 AM - 10:00 AM</option>
                <option value="01:00 PM - 02:00 PM" {{ $gsession->s_time === "01:00 PM - 02:00 PM" ? 'selected' : '' }}>01:00 PM - 02:00 PM</option>
                <option value="01:00 PM - 03:00 PM" {{ $gsession->s_time === "01:00 PM - 03:00 PM" ? 'selected' : '' }}>01:00 PM - 03:00 PM</option>
                <option value="05:00 PM - 06:00 PM" {{ $gsession->s_time === "05:00 PM - 06:00 PM" ? 'selected' : '' }}>05:00 PM - 06:00 PM</option>
                <option value="05:00 PM - 07:00 PM" {{ $gsession->s_time === "05:00 PM - 07:00 PM" ? 'selected' : '' }}>05:00 PM - 07:00 PM</option>
                <option value="06:00 PM - 07:00 PM" {{ $gsession->s_time === "06:00 PM - 07:00 PM" ? 'selected' : '' }}>06:00 PM - 07:00 PM</option>
                <option value="06:00 PM - 08:00 PM" {{ $gsession->s_time === "06:00 PM - 08:00 PM" ? 'selected' : '' }}>06:00 PM - 08:00 PM</option>
                <option value="07:00 PM - 08:00 PM" {{ $gsession->s_time === "07:00 PM - 08:00 PM" ? 'selected' : '' }}>07:00 PM - 08:00 PM</option>
                <option value="07:00 PM - 09:00 PM" {{ $gsession->s_time === "07:00 PM - 09:00 PM" ? 'selected' : '' }}>07:00 PM - 09:00 PM</option>
                <option value="08:00 PM - 09:00 PM" {{ $gsession->s_time === "08:00 PM - 09:00 PM" ? 'selected' : '' }}>08:00 PM - 09:00 PM</option>
            </select>
            <br>

            <label for="c_id">Customer ID:</label>
            <input type="text" id="c_id" name="c_id" value="{{ $gsession->c_id }}" required>
            <br>

            <label for="t_id">Trainer ID:</label>
            <input type="text" id="t_id" name="t_id" value="{{ $gsession->t_id }}">
            <br>

            @if(session('error'))
                <div style="color: rgb(233, 5, 5);">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->has('c_id') && $errors->has('t_id'))
                <div style="color: rgb(233, 5, 5);">Both Customer ID and Trainer ID are not available in the database.</div>
            @elseif($errors->has('c_id'))
                <div style="color: rgb(233, 5, 5);">{{ $errors->first('c_id') }}</div>
            @elseif($errors->has('t_id'))
                <div style="color: rgb(233, 5, 5);">{{ $errors->first('t_id') }}</div>
            @endif
            <br>

            <div class="button-group">
                <a class="cancel-button" href="{{ route('sessions') }}">Back</a>
                <button type="submit">Update</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

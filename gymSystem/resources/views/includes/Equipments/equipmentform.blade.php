@extends('homepage')
@section('title', 'Equipment Details Form')
@section('content')
<div class="detailsform">
    <form action="{{ route('storeequipment') }}" method="POST" autocomplete="off">
        @csrf

        <h1>Equipment Details Form</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label style="width: 120px;" for="e_id">Equipment ID:</label>
            <input type="text" id="e_id" name="e_id" value="{{ $e_id }}" readonly required>
            <br>
    
            <label style="width: 120px;" for="name">Name:</label>
            <input style="width: 280px;" type="text" id="name" name="name" required>
            <br>
    

            <label style="width: 120px;" for="brand">Brand:</label>
            <input style="width: 280px;" type="text" id="brand" name="brand" required>
            <br>

            <label style="width: 120px;" for="serial">Serial:</label>
            <input type="text" id="serial" name="serial" required>
            <br>

            <label style="width: 120px;" for="price">Price (INR):</label>
            <input type="number" step="0.01" id="price" name="price" required>
            <br>

            <label  style="width: 120px;" for="purchased_date">Purchased Date:</label>
            <input style="width: 150px;" type="date" id="purchased_date" name="purchased_date" required>
            <br><br>
    
            <div class="button-group">
                <a class="cancel-button" href="{{route('equipments')}}">Cancel</a>
                <button type="submit">Submit</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

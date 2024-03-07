@extends('homepage')
@section('title', 'Edit Equipment Details')
@section('content')
<div class="detailsform">
    <form action="{{ route('updateequipment', $equipment->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <h1>Edit Equipment Details</h1>
        <div class="sep"></div>

        <div class="entryform">
            <label style="width: 120px;" for="e_id">Equipment ID:</label>
            <input type="text" id="e_id" name="e_id"  value="{{ $equipment->e_id }}" readonly required>
            <br>
    
            <label style="width: 120px;" for="name">Name:</label>
            <input style="width: 280px;" type="text" id="name" name="name" value="{{ $equipment->name }}" required>
            <br>
    

            <label style="width: 120px;" for="brand">Brand:</label> 
            <input style="width: 280px;" type="text" id="brand" name="brand" value="{{ $equipment->brand }}" required>
            <br>

            <label style="width: 120px;" for="serial">Serial:</label>
            <input type="text" id="serial" name="serial" value="{{ $equipment->serial }}" required>
            <br>

            <label style="width: 120px;" for="price">Price (INR):</label>
            <input type="number" step="0.01" id="price" name="price" value="{{ $equipment->price }}" required>
            <br>

            <label  style="width: 120px;" for="purchased_date">Purchased Date:</label>
            <input style="width: 150px;" type="date" id="purchased_date" name="purchased_date" value="{{ $equipment->purchased_date }}" required>
            <br><br>
            
            <div style="color: rgb(233, 5, 5);">
                @if($errors->any())
                    <div class="error-message">Validation errors occurred. Please enter the correct details.</div>
                @endif
            </div>
            <br> 

            <div class="button-group">
                <a class="cancel-button" href="{{ route('equipments') }}">Cancel</a>
                <button type="submit">Update</button>
            </div>
        </div>
        
    </form>
</div>
@endsection
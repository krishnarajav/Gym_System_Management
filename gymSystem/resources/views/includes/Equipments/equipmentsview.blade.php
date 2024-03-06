@extends('homepage')
@section('title', 'Equipments View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Equipments</h1>
        <a class="add-button" href="{{route('equipmentform')}}">
            <button class="add-btn">Add</button>
        </a>
        <!--        <form class="search-bar">
            <input type="search" placeholder="Search" aria-label="Search">
            <button type="submit">Search</button>
        </form>-->
        <div class="sep"></div>
    </div>    
    <div class="table-container">
        <table class="display-table">
            <thead>
                <tr style="height: 50px;">
                    <th>Equipment ID</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Serial</th>
                    <th>Purchased Date</th>
                    <th>Price (INR)</th>
                    <th style="width: 50px;">Edit</th>
                    <th style="width: 60px;">Delete</th>
                </tr>
            </thead>
    
            <tbody>
                @if(isset($equipments) && count($equipments) > 0)
                    @foreach($equipments as $equipment)
                        <tr style="height: 60px;">
                            <td>{{ $equipment->e_id }}</td>
                            <td>{{ $equipment->name}}</td>
                            <td>{{ $equipment->brand}}</td>
                            <td>{{ $equipment->serial}}</td>
                            <td>{{ \Carbon\Carbon::parse($equipment->purchased_date)->format('d-m-Y') }}</td>
                            <td>{{ $equipment->price}}</td>
                            <td><div class="edit-button"><a href="{{ route('editequipment', $equipment->id) }}">View</a></div></td>
                            <td>
                                <div class="delete-button">
                                    <form action="{{ route('deleteequipment', $equipment->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this equipment?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach 
                @else
                    <tr>
                        <td colspan="13">No entries available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
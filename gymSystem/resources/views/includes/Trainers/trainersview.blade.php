@extends('homepage')
@section('title', 'Trainers View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Trainers</h1>
        <a class="add-button" href="{{route('trainerform')}}">
            <button class="add-btn">Add</button>
        </a>
        <form class="search-bar">
            <input type="search" placeholder="Search" aria-label="Search">
            <button type="submit">Search</button>
        </form>
        <div class="sep"></div>
    </div>    
    <table class="customers-table">
        <thead>
            <tr>
                <th>Trainer ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Experience</th>
                <th>Address</th>
                <th>Mobile</th>
                <th>Salary</th>
            </tr>
        </thead>
    <!--
        <tbody>
        {{--    @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->c_id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->dob }}</td>
                    <td>{{ $customer->age }}</td>
                    <td>{{ $customer->gender }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->mobile }}</td>
                    <td>{{ $customer->p_id }}</td>
                    <td>{{ $customer->p_start }}</td>
                    <td>{{ $customer->p_end }}</td>
                </tr>
            @endforeach
        --}}
        </tbody>
    -->
    </table>
</div>
@endsection
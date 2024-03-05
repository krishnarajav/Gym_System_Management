@extends('homepage')
@section('title', 'Sessions View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Sessions</h1>
        <a class="add-button" href="{{route('sessionform')}}">
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
                <th>Session ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Customer ID</th>
                <th>Trainer ID</th>
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
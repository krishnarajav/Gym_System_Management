@extends('homepage')
@section('title', 'Customers View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Customers</h1>
        <a class="add-button" href="{{route('customerform')}}">
            <button class="add-btn">Add</button>
        </a>
        <!--<form class="search-bar" action="#" method="get" autocomplete="off">
            <input type="search" name="search" placeholder="Search" aria-label="Search">
            <button type="submit">Search</button>
        </form>-->
        <div class="sep"></div>
    </div>
    <div class="table-container">
        <table class="display-table">
            <thead>
                <tr style="height: 50px;">
                    <th style="max-width: 80px;">Customer ID</th>
                    <th style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Mobile</th>
                    <th>Plan ID</th>
                    <th>Plan End</th>
                    <th>Plan Status</th>
                    <th style="width: 50px;">View / Edit</th>
                    <th style="width: 60px;">Delete</th>
                </tr>
            </thead>
    
            <tbody>
                @if(isset($customers) && count($customers) > 0)
                    @foreach($customers as $customer)
                        <tr style="height: 60px;">
                            <td style="max-width: 80px;">{{ $customer->c_id }}</td>
                            <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $customer->name }}</td>
                            <td>{{ $customer->age }}</td>
                            <td>{{ $customer->gender }}</td>
                            <td>{{ $customer->mobile }}</td>
                            <td>{{ $customer->p_id }}</td>
                            <td>{{ $customer->p_end ? \Carbon\Carbon::parse($customer->p_end)->format('d-m-Y') : '' }}</td>
                            <td>{{ $customer->p_status }}</td>
                            <td><div class="edit-button"><a href="{{ route('editcustomer', $customer->id) }}">View</a></div></td>
                            <td>
                                <div class="delete-button">
                                    <form action="{{ route('deletecustomer', $customer->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
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
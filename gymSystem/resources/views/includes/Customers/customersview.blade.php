@extends('homepage')
@section('title', 'Customers View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Customers</h1>
        <a class="add-button" href="{{route('customerform')}}">
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
                    <th style="max-width: 80px;">Customer ID</th>
                    <th style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Name</th>
                    <th>DOB</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">Address</th>
                    <th>Mobile</th>
                    <th>Date Joined</th>
                    <th>Plan ID</th>
                    <th>Plan Start</th>
                    <th>Plan End</th>
                    <th style="width: 50px;">Edit</th>
                    <th style="width: 60px;">Delete</th>
                </tr>
            </thead>
    
            <tbody>
                @if(isset($customers) && count($customers) > 0)
                    @foreach($customers as $customer)
                        <tr style="height: 60px;">
                            <td style="max-width: 80px;">{{ $customer->c_id }}</td>
                            <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $customer->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($customer->dob)->format('d-m-Y') }}</td>
                            <td>{{ $customer->age }}</td>
                            <td>{{ $customer->gender }}</td>
                            <td style="text-align: left; max-width: 150px; overflow: hidden; text-overflow: ellipsis;">{{ $customer->address }}</td>
                            <td>{{ $customer->mobile }}</td>
                            <td>{{ $customer->created_at->format('d-m-Y') }}</td>
                            <td>{{ $customer->p_id }}</td>
                            <td>{{ $customer->p_start ? \Carbon\Carbon::parse($customer->p_start)->format('d-m-Y') : '' }}</td>
                            <td>{{ $customer->p_end ? \Carbon\Carbon::parse($customer->p_end)->format('d-m-Y') : '' }}</td>
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
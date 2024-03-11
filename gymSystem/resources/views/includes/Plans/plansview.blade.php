@extends('homepage')
@section('title', 'Plans View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Plans</h1>
        <a class="add-button" href="{{route('planform')}}">
            <button class="add-btn">Add</button>
        </a>
       <!-- <form class="search-bar" action="#" method="get" autocomplete="off">
            <input type="search" name="search" placeholder="Search" aria-label="Search">
            <button type="submit">Search</button>
        </form>-->
        <div class="sep"></div>
    </div>    
    <div class="table-container">
        <table class="display-table">
            <thead>
                <tr style="height: 50px;">
                    <th>Plan ID</th>
                    <th>Name</th>
                    <th>Period (Days)</th>
                    <th>Price (INR)</th>
                    <th style="width: 50px;">View / Edit</th>
                    <th style="width: 60px;">Delete</th>
                </tr>
            </thead>
    
            <tbody>
                @if(isset($plans) && count($plans) > 0)
                    @foreach($plans as $plan)
                        <tr style="height: 60px;">
                            <td>{{ $plan->p_id }}</td>
                            <td>{{ $plan->name}}</td>
                            <td>{{ $plan->period}}</td>
                            <td>{{ $plan->price}}</td>
                            <td><div class="edit-button"><a href="{{ route('editplan', $plan->id) }}">View</a></div></td>
                            <td>
                                <div class="delete-button">
                                    <form action="{{ route('deleteplan', $plan->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
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
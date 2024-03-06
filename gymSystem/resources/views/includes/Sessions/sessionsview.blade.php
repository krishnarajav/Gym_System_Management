@extends('homepage')
@section('title', 'Sessions View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Sessions</h1>
        <a class="add-button" href="{{route('sessionform')}}">
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
                    <th>Date</th>
                    <th>Time</th>
                    <th>Customer ID</th>
                    <th>Trainer ID</th>
                    <th style="width: 50px;">Edit</th>
                    <th style="width: 60px;">Delete</th>
                </tr>
            </thead>
    
            <tbody>
                @if(isset($gsessions) && count($gsessions) > 0)
                    @foreach($gsessions as $gsession)
                        <tr style="height: 60px;">
                            <td>{{ \Carbon\Carbon::parse($gsession->s_date)->format('d-m-Y') }}</td>
                            <td>{{ $gsession->s_time }}</td>
                            <td>{{ $gsession->c_id }}</td>
                            <td>{{ $gsession->t_id }}</td>
                            <td>
                                <div class="edit-button">
                                    <a href="{{ route('editsession', $gsession->id) }}">View</a>
                                </div>
                            </td>
                            <td>
                                <div class="delete-button">
                                    <form action="{{ route('deletesession', $gsession->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this session?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach 
                @else
                    <tr>
                        <td colspan="6">No entries available.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
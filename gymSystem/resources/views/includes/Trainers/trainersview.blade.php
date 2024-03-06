@extends('homepage')
@section('title', 'Trainers View')
@section('content')
<div class="detail-container">
    <div class="elementary">
        <h1>Trainers</h1>
        <a class="add-button" href="{{route('trainerform')}}">
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
                    <th style="max-width: 80px;">Trainer ID</th>
                    <th style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Name</th>
                    <th>DOB</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">Address</th>
                    <th>Mobile</th>
                    <th>Experience</th>
                    <th>Date Joined</th>
                    <th>Salary</th>
                    <th style="width: 50px;">Edit</th>
                    <th style="width: 60px;">Delete</th>
                </tr>
            </thead>
    
            <tbody>
                @if(isset($trainers) && count($trainers) > 0)
                    @foreach($trainers as $trainer)
                        <tr style="height: 60px;">
                            <td style="max-width: 80px;">{{ $trainer->t_id }}</td>
                            <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $trainer->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($trainer->dob)->format('d-m-Y') }}</td>
                            <td>{{ $trainer->age }}</td>
                            <td>{{ $trainer->gender }}</td>
                            <td style="text-align: left; max-width: 150px; overflow: hidden; text-overflow: ellipsis;">{{ $trainer->address }}</td>
                            <td>{{ $trainer->mobile }}</td>
                            <td>{{ $trainer->experience }}</td>
                            <td>{{ $trainer->created_at->format('d-m-Y') }}</td>
                            <td>{{ $trainer->salary }}</td>
                            <td><div class="edit-button"><a href="{{ route('edittrainer', $trainer->id) }}">View</a></div></td>
                            <td>
                                <div class="delete-button">
                                    <form action="{{ route('deletetrainer', $trainer->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this trainer?')">Delete</button>
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
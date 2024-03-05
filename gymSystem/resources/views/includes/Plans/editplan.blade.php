@extends('homepage')
@section('title', 'Edit Plan')
@section('content')
<div class="detailsform">
    <form action="{{ route('updateplan', $plan->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <h1>Edit Plan</h1>
        <div class="sep"></div>
@extends('emails.layouts.main')

@section('title', 'Welcome to bookstore')
@section('subtitle', 'Your account is ready')

@section('content')
    <h2>We are happy to have you onboard</h2>

    <p>your password is: {{ $details["password"] }} </p>
    <p>Please endeavour to change your password upon sign in </p>

@endsection

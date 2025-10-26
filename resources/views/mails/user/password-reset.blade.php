@extends('mails.layouts.main')

@section('title', 'Password Reset Request')
@section('subtitle', 'Your password reset code')

@section('content')
    <p><strong> Your verification code is::</strong> {{ $code }}</p>
    <p><strong> If you did not request a password reset, please ignore this email. </strong></p>
    This code expires in 10 minutes.
@endsection


@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Create event
@endsection

@section('main-content')
    {{ Session::get('status') }}


    <h1>Create Event:</h1>
    <form action="/events" method="POST">
        {{ csrf_field() }}
        <input type="text" name="name" value="" placeholder="Name" id="name">
        <textarea name="description" id="description" cols="30" rows="10" placeholder="Put your description here"></textarea>
        <input type="submit" value="Create">
    </form>
@endsection


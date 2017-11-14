@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Events list
@endsection

@section('main-content')
    <h1>Edit Event:</h1>
    <form action="/events/{{ $event->id }}" method="POST">
        <input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}
        <input type="text" name="name" value="{{ $event->name }}" placeholder="Name">
        <textarea name="description" id="description" cols="30" rows="10" placeholder="Put your description here">{{ $event->description }}</textarea>
        <input type="submit" value="Update">
    </form>
@endsection

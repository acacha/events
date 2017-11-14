@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Event
@endsection


@section('main-content')
    <form action="/events_php/{{ $event->id }}" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="btn-group">
            <a href="/events_php" class="btn btn-success" role="button" aria-disabled="true"> < Back</a>
            <a href="/events_php/edit/{{ $event->id}}" class="btn btn-warning" role="button" aria-disabled="true">Edit</a>
            <button type="submit" class="btn btn-danger">Delete</button>
        </div>
    </form>


    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Event:</h3>
        </div>
        <div class="box-body">
            <ul>
                <li>Id: {{ $event->id }}</li>
                <li>Name: {{ $event->name }}</li>
                <li>Description: {{ $event->description }}</li>
            </ul>
        </div>
    </div>
@endsection


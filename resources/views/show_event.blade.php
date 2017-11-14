@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Event
@endsection


@section('main-content')
<h1>Event:</h1>

<ul>
    <li>Name: {{ $event->name }}</li>
    <li>Description: {{ $event->description }}</li>
</ul>
@endsection


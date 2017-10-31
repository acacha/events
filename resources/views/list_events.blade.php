<h1>Event:</h1>

{{ Session::get('status') }}


@foreach ($events as $event)
    <ul>
        <li>Name: {{ $event->name }}</li>
        <li>Description: {{ $event->description }}</li>
        <li>
            <form action="/events/{{ $event->id }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" value="delete">
            </form>
        </li>
    </ul>
@endforeach

{{ Session::get('status') or '' }}
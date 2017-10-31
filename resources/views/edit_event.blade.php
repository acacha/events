<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h1>Edit Event:</h1>
<form action="/events" method="POST">
    <input type="hidden" name="_method" value="PUT">
    {{ csrf_field() }}
    <input type="text" name="name" value="{{ $event->name }}" placeholder="Name">
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Put your description here">{{ $event->description }}</textarea>
    <input type="submit" value="Update">
</form>

</body>
</html>
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

<h1>Create Event:</h1>
<form action="/events" method="POST">
    {{ csrf_field() }}
    <input type="text" name="name" value="" placeholder="Name">
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Put your description here"></textarea>
    <input type="submit" value="Create">
</form>

</body>
</html>
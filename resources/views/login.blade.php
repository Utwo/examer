<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Login</div>
        <form method="post" action="{{route('post_login')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="text" name="name" required>
            <input type="password" name="password" required>
            <button type="submit">Log in</button>
        </form>
    </div>
</div>
</body>
</html>

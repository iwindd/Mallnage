<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>COOPERATIVE : BANNED</title>
    <style>
        h1{
            color: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>บัญชีของคุณถูกระงับใช้งานชั่วคราว</h1>
        <form action="{{route('logout')}}" method="post">
            @csrf
            <input type="submit" value="logout">
        </form>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Foode - Login</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    {{-- <form method=POST action="{{ route('admin.login.auth') }}">
        <input type='text' name='email' />
        <br>
        <input type='password' name='password' />
        <br>
        <input type='submit' name='Login' />
        <br>
    </form> --}}

<form method="POST" action="{{ route('admin.login.auth') }}">

    @csrf

    {{-- @if($errors->has('name'))
        @foreach($errors->get('name') as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif --}}

    @error('email')
        <p>{{$massage}}</p>
    @enderror
    <input type='text' name='email' value='sarach.jons@rolty.com'/>
    <br>

    @error('password')
        <p>{{$massage}}</p>
    @enderror
    <input type='password' name='password' value='password'/>
    <br>

    <input type='submit' name='Login' />
    <br>

</form>



    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

</body>

</html>
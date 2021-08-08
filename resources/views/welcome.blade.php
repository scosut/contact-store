<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Contact Store</title>
  <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
</head>
<body class="fadeIn">
  <div class="container">
    <div id="app">
      <contacts></contacts>
    </div>
  </div>

  <script src="{{ asset('public/js/app.js') }}"></script>
</body>
</html>
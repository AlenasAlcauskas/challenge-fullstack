<!DOCTYPE html>
<html style="background-color: #ededed">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{env('APP_NAME')}}</title>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="antialiased" style="margin: 0; padding: 0;">
<div id="app">
    <app/>
</div>
</body>
</html>
<script src="{{ mix('js/app.js') }}">
</script>

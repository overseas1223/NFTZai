<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{__('Title')}}</title>
</head>
<body>
<a href="{{route('verify_web', ['email' => $data->email, 'token' => encrypt($key)])}}">{{__('Click Here')}}</a>
</body>
</html>

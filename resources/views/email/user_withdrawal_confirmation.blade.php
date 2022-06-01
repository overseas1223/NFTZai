<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
<table id="emailContainer">
    <tr>
        <td><img src="{{asset(path_image().allsetting('logo'))}}"></td>
    </tr>
    <tr>
        <td>
            <table id="email-body">
                <tr>
                    <td>
                        <h1> {{__('Confirm')}}</h1>
                        <h2> {{__('Your Withdrawal')}}</h2>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <br>
                        <strong>{{__('Hello')}} {{$username}}</strong>
                        <br>
                        <br>
                        <p>{{__('In order to verify your withdrawal please enter the following code.')}}</p>
                        <br>
                        <br>
                        <div class="user-id">
                            {{$vfcode}}</div>
                        <br>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>{{__('Thanks a lot for being with us.')}}</strong>
                        <p>{{__('NFTzai Team .')}}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <!-- Start Email Container -->
    <table id="emailContainer">
        <tr>
            <td><img src="{{asset(path_image().allsetting('logo'))}}"></td>
        </tr>
        <tr>
            <td id="emailContainerCell">
                <!-- Start Email Body Area -->
                <table id="email-body">
                    <tr>
                        <td>
                            <h1> {{__('Deposit')}}</h1>
                            <h2> {{__('Coin')}}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                            <br>
                            <h3>{{__('Hello,')}} {{ $user->first_name}} {{ $user->last_name}}</h3>
                            <br>
                            <br>
                            <p> {{  __('You received :amount :coin at :address.',['amount'=> $amount, 'coin' => $coin, 'address' => $address]) }}</p>
                            <br>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <strong>{{__('Thanks a lot for being with us.')}}</strong>
                            <p>{{__('Nftzai Pro Team .')}}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

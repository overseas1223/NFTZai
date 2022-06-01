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
        <td id="emailContainerCell">
            <table id="email-body">
                <tr>
                    <td>
                        <h1> {{__('Withdrawal Cancle')}}</h1>
                        <h2> {{__('Notification')}}</h2>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <br>
                        <h3>{{__('Hello')}} {{ $user->first_name }} {{$user->last_name}}</h3>
                        <br>
                        <br>
                        <p>{{ __('Your recent withdrawal request is cancelled by system. Please resubmit the withdrawal request or contact our support team.', ['reason'=>$reason])}}</p>
                        <br>
                        <br>

                        <h3>{{ __('Withdrawal Detail :') }}</h3>
                        <br>
                        <br>
                        <ul>
                            <li>{{__('Withdrawal Amount:')}} {{ $amount }} {{ $coinType }}</li>
                            <li>{{__('Withdrawal Fee:')}} {{ $fee }} {{ $coinType }}</li>
                            <li>
                                {{__('Withdrawal Status:')}} {{ config('arrayconstants.withdrawal_status.' . $status) }}
                            </li>
                            <li>
                                {{__('Withdrawal Cancellation Reason :')}} {{ $reason }}
                            </li>
                        </ul>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>{{__('Thanks a lot for being with us.')}}</strong>
                        <p>{{__('Nftzai Team .')}}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

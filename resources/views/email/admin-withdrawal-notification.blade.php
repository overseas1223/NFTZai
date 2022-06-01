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
            <!-- email header top start -->
            <table>
                <tr>
                    <td> {{__('We are building the future of crypto currency.')}}</td>
                    <td><a href="{{env('APP_URL')}}">{{env('APP_URL')}}</a>
                    </td>
                </tr>
            </table>
            <!-- Start Email Body Area -->
            <table id="email-body">
                <tr>
                    <td colspan="2">
                        <h3>{{__('Hello Mr. Admin')}}</h3>
                        <br>
                        <br>
                        <p>{{ __('A user recently have withdrawn some coins.') }}</p>
                        <br>
                        <br>
                        <h3>{{ __('Withdrawal Detail :') }}</h3>
                        <br>
                        <br>
                        <ul>
                            <li>{{__('User Name: ')}} {{ $data->first_name . " " . $data->last_name }}</li>
                            <li>{{__('User Email: ')}} {{ $data->email }}</li>
                            <li>{{__('Withdrawal Amount:')}} {{ $amount }} {{ $coinType }}</li>
                            <li>{{__('Withdrawal Fee:')}} {{ $fees }} {{ $coinType }}</li>
                            <li>
                                {{__('Withdrawal Status:')}} {{ config('arrayconstants.withdrawal_status.' . $status) }}
                                {{ $status == 2 ? __(', It needs admin approval.') : '' }}
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

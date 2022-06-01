<h3>{{__('Hello')}}, {{isset($user) ? $user->first_name.' '.$user->last_name : ''}}</h3>
<p>
    {{__('You are receiving this email because we received a password reset request for your account.
    Please use the code below to reset your password.')}}
</p>
<p>
    {{$token}}
</p>
<p>{{__('You can change your password with this link ::')}} <a href="{{route('reset_password_page')}}">{{__('Click Here')}}</a></p>

<p>
    {{__('Thanks a lot for being with us.')}} <br/>
    {{allSetting()['app_title']}}
</p>

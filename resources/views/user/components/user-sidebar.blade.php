<div class="user-dashboard-sidebar-menu text-left">
    <ul>
        <li><a href="{{route('login')}}" class="@if(isset($menu) && $menu == 'dashboard') active @endif"><span><i class="fas fa-grip-horizontal"></i></span>{{__('Dashboard')}}</a></li>
        <li><a href="{{route('my_wallets')}}" class="@if(isset($menu) && $menu == 'my-wallet') active @endif"><span><i class="fas fa-wallet"></i></span>{{__('My wallet')}}</a></li>
        <li><a href="{{route('my_service_data')}}" class="@if(isset($menu) && $menu == 'my-service-data') active @endif"><span><i class="fas fa-project-diagram"></i></span>{{__('My Artworks')}}</a></li>
        <li><a href="{{route('my_earnings')}}" class="@if(isset($menu) && $menu == 'my-earnings') active @endif"><span><i class="fas fa-coins"></i></span>{{__('My Earnings')}}</a></li>
        <li><a href="{{route('deposit_data')}}" class="@if(isset($menu) && $menu == 'deposit-data') active @endif"><span><i class="fas fa-hand-holding-usd"></i></span>{{__('Deposit History')}}</a></li>
        <li><a href="{{route('withdraw_data')}}" class="@if(isset($menu) && $menu == 'withdraw-data') active @endif"><span><i class="far fa-money-bill-alt"></i></span>{{__('Withdraw History')}}</a></li>
        <li><a href="{{route('purchase_history')}}" class="@if(isset($menu) && $menu == 'purchase-history') active @endif"><span><i class="fas fa-history"></i></span>{{__('Purchase')}}</a></li>
        <li><a href="{{route('bid_history')}}" class="@if(isset($menu) && $menu == 'bid-history') active @endif"><span><i class="fas fa-chart-line"></i></span>{{__('Bid')}}</a></li>
        <li><a href="{{route('edit_profile')}}"><span><i class="fas fa-cogs"></i></span>{{__('Profile')}}</a></li>
    </ul>
</div>

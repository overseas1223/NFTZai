<?php

//User Roles
function userRole($input = null)
{
    $output = [
        USER_ROLE_ADMIN => __('Admin'),
        USER_ROLE_USER => __('User')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
//User Activity Array
function userActivity($input = null)
{
    $output = [
         USER_ACTIVITY_LOGIN => __('Log In'),
         USER_ACTIVITY_MOVE_COIN => __("Move Coin"),
         USER_ACTIVITY_WITHDRAWAL => __('Withdraw Coin'),
         USER_ACTIVITY_CREATE_WALLET => __('Create New Wallet'),
         USER_ACTIVITY_CREATE_ADDRESS => __('Create New Address'),
         USER_ACTIVITY_MAKE_PRIMARY_WALLET => __('Make Wallet Primary'),
         USER_ACTIVITY_PROFILE_IMAGE_UPLOAD => __('Upload Profile Picture'),
         USER_ACTIVITY_UPDATE_PASSWORD => __('Update Password'),
         USER_ACTIVITY_LOGOUT => __("Logout"),
         USER_ACTIVITY_PROFILE_UPDATE => __('Profile Update')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
//Discount Type array
function discount_type($input = null)
{
    $output = [
        DISCOUNT_TYPE_FIXED => __('Fixed'),
        DISCOUNT_TYPE_PERCENTAGE => __('Percentage')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

 function sendFeesType($input = null){
    $output = [
        DISCOUNT_TYPE_FIXED => __('Fixed'),
        DISCOUNT_TYPE_PERCENTAGE => __('Percentage')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function status($input = null)
{
    $output = [
        STATUS_ACTIVE => __('Active'),
        STATUS_DEACTIVE => __('Deactive'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function deposit_status($input = null)
{
    $output = [
        STATUS_ACCEPTED => __('Accepted'),
        STATUS_PENDING => __('Pending'),
        STATUS_REJECTED => __('Rejected'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function byCoinType($input = null)
{
    $output = [
        CARD => __('CARD'),
        BTC => __('Coin Payment'),
        BANK_DEPOSIT => __('BANK DEPOSIT'),

    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function addressType($input = null){
    $output = [

        ADDRESS_TYPE_INTERNAL => __('Internal'),
        ADDRESS_TYPE_EXTERNAL => __('External'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


function statusAction($input = null)
{
    $output = [
        STATUS_PENDING => __('Pending'),
        STATUS_SUCCESS => __('Active'),
        STATUS_REJECTED => __('Rejected'),
        STATUS_SUSPENDED => __('Suspended'),
        STATUS_DELETED => __('Deleted'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


function actions($input = null)
{
    $output = [

    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function days($input=null){
    $output = [
        DAY_OF_WEEK_MONDAY => __('Monday'),
        DAY_OF_WEEK_TUESDAY => __('Tuesday'),
        DAY_OF_WEEK_WEDNESDAY => __('Wednesday'),
        DAY_OF_WEEK_THURSDAY => __('Thursday'),
        DAY_OF_WEEK_FRIDAY => __('Friday'),
        DAY_OF_WEEK_SATURDAY => __('Saturday'),
        DAY_OF_WEEK_SUNDAY => __('Sunday')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function months($input=null){
    $output = [
        1 => __('January'),
        2 => __('February'),
        3 => __('Merch'),
        4 => __('April'),
        5 => __('May'),
        6 => __('June'),
        7 => __('July'),
        8 => __('August'),
        9 => __('September'),
        10 => __('October'),
        11 => __('November'),
        12 => __('December'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function customPages($input=null){
    $output = [
        'faqs' => __('FAQS'),
        't_and_c' => __('T&C')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


function paymentTypes($input = null)
{
    if (env('APP_ENV') == 'production' )
        $output = [
            PAYMENT_TYPE_LTC => 'LTC',
            PAYMENT_TYPE_BTC => 'BTC',
            PAYMENT_TYPE_USD => 'USDT',
            PAYMENT_TYPE_ETH => 'ETH',
            PAYMENT_TYPE_DOGE => 'DOGE',
            PAYMENT_TYPE_BCH => 'BCH',
            PAYMENT_TYPE_DASH => 'DASH',
        ];
    else
        $output = [
            PAYMENT_TYPE_LTC => 'LTCT',
            PAYMENT_TYPE_BTC => 'BTC',
            PAYMENT_TYPE_USD => 'USDT',
            PAYMENT_TYPE_ETH => 'ETH',
            PAYMENT_TYPE_DOGE => 'DOGE',
            PAYMENT_TYPE_BCH => 'BCH',
            PAYMENT_TYPE_DASH => 'DASH',
        ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

// payment method list
function paymentMethods($input = null)
{
    $output = [
        BTC => __('Coin Payment'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}



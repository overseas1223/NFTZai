<?php


// User Role Type
const USER_ROLE_ADMIN = 1;
const USER_ROLE_USER = 2;



// Status
const STATUS_PENDING = 0;
const STATUS_ACCEPTED = 1;
const STATUS_REJECTED = 2;
const STATUS_SUCCESS = 1;
const STATUS_SUSPENDED = 4;
const STATUS_DELETED = 5;
const STATUS_ALL = 6;

const STATUS_ACTIVE = 1;
const STATUS_DEACTIVE = 0;

const BTC = 1;
const CARD = 2;
const PAYPAL = 3;
const BANK_DEPOSIT = 4;


const  SEND_FEES_FIXED  = 1;
const  SEND_FEES_PERCENTAGE  = 2;

const  SERVICE_CHARGE_FIXED  = 1;
const  SERVICE_CHARGE_PERCENTAGE  = 2;

// Transaction Status
const TRANS_DEPOSIT = 1;
const TRANS_WITHDRAW = 2;
const TRANS_SOLD = 3;
const TRANS_BID_WIN = 4;
const TRANS_BID_HOLD = 5;
const TRANS_BID_REFUND = 6;

//Verification send Type
const Mail = 1;
const PHONE = 2;

const IOS = 1;
const ANDROIND = 2;

// User Activity
const ADDRESS_TYPE_EXTERNAL = 1;
const ADDRESS_TYPE_INTERNAL = 2;

const IMG_PATH = 'uploaded_file/uploads/';
const IMG_VIEW_PATH = 'uploaded_file/uploads/';
const IMG_STATIC_PATH = 'assets/user/img/';

const IMG_USER_PATH = 'uploaded_file/users/';
const IMG_SLEEP_PATH = 'uploaded_file/sleep/';
const IMG_USER_VIEW_PATH = 'uploaded_file/users/';
const IMG_USER_COVER_PHOTO = 'uploaded_file/users/cover-photo/';
const IMG_SLEEP_VIEW_PATH = 'uploaded_file/sleep/';
const IMG_USER_VERIFICATION_PATH = 'users/verifications/';
const IMG_SERVICE_PATH = 'uploaded_file/services/';
const IMG_NEWS_PATH = 'uploaded_file/news/';
const FILE_PATH = 'uploaded_file/files/';

const DISCOUNT_TYPE_FIXED = 1;
const DISCOUNT_TYPE_PERCENTAGE = 2;

const DEPOSIT = 1;
const WITHDRAWAL = 2;

const PAYMENT_TYPE_BTC = 1;
const PAYMENT_TYPE_USD = 2;
const PAYMENT_TYPE_ETH = 3;
const PAYMENT_TYPE_LTC = 4;
const PAYMENT_TYPE_LTCT = 5;
const PAYMENT_TYPE_DOGE = 6;
const PAYMENT_TYPE_BCH = 7;
const PAYMENT_TYPE_DASH = 8;

// plan bonus
const PLAN_BONUS_TYPE_FIXED = 1;
const PLAN_BONUS_TYPE_PERCENTAGE = 2;

//
const CREDIT = 1;
const DEBIT = 2;

//User Activity
const USER_ACTIVITY_LOGIN=1;
const USER_ACTIVITY_MOVE_COIN=2;
const USER_ACTIVITY_WITHDRAWAL=3;
const USER_ACTIVITY_CREATE_WALLET=4;
const USER_ACTIVITY_CREATE_ADDRESS=5;
const USER_ACTIVITY_MAKE_PRIMARY_WALLET=6;
const USER_ACTIVITY_PROFILE_IMAGE_UPLOAD=7;
const USER_ACTIVITY_UPDATE_PASSWORD=8;
const USER_ACTIVITY_UPDATE_EMAIL=12;
const USER_ACTIVITY_ACTIVE=9;
const USER_ACTIVITY_HALF_ACTIVE=10;
const USER_ACTIVITY_INACTIVE=11;
const USER_ACTIVITY_LOGOUT=12;
const USER_ACTIVITY_PROFILE_UPDATE=13;

//Service Type
const FIXED_PRICE = 1;
const BID_PRICE = 2;

//Fees Type
const FEES_FIXED = 1;
const FEES_PERCENTAGE = 2;

//Service Status
const DRAFT = 0;
const PENDING = 0;
const ON_ADMIN_APPROVAL = 1;
const APPROVED = 2;
const SUCCESS = 2;
const ACCEPTED = 2;
const PROCESSING = 3;
const FAILED_ON_NODE = 4;
const ERROR = 5;
const USER_CANCEL = 6;
const ADMIN_CANCEL = 7;
const STATUS_RECHECK = 8;
const SOLD = 9;
const UNSOLD = 10;

//Gender
const MALE = 1;
CONST FEMALE = 2;


const WITHDRAWAL_FEES_FIXED = 1;
const WITHDRAWAL_FEES_PERCENTAGE = 2;
const WITHDRAWAL_FEES_BOTH = 3;

//Mint Verification URL
const MINT_URL = 'https://etherscan.io/address/';

//Dummy Mint Token
const MINT_TOKEN_1 = '0x847884b3f87164cc6cfa0486ab4a75cda363dbb0603c2ae06816b1fbae624428';
const MINT_TOKEN_2 = '0x0574eb0626c0337161ce18bf76c0e7917f33ef3e21d756b39ba1d25fbe96f257';
const MINT_TOKEN_3 = '0xd73505316f2c2b0d5c2dd1907301fbd8925914f2d32ce0982c2853c91883258f';
const MINT_TOKEN_4 = '0x83a89fe829f05d552a84ced49b210bb1c18d0507495d2b3a91e9e8c58829366a';
const MINT_TOKEN_5 = '0x4ccb56d25a6441c4d972b616b3e601da47846c046b61599d7363cd017154da76';
const MINT_TOKEN_6 = '0x1374370d0436284bd65455ce78f574fa919352962bdb38be3e52d6d8026261ba';
const MINT_TOKEN_7 = '0xea5a635576c8cb68968521f156002ecc10a023330e9154da2af720e8d9182ddc';
const MINT_TOKEN_8 = '0x603c22aeba2fc7f8d02ed78a8fd561ab9e4dcabed3f16355577948eba1b8351e';
const MINT_TOKEN_9 = '0x699fd437c69d808e941794c16592d5c48d02b736b96fdfc97f2d1572467142a4';
const MINT_TOKEN_10 = '0x9ef8b01a1b5318c97aaabc57df2be5e5478730034ef90edd06c78dbae6eed894';

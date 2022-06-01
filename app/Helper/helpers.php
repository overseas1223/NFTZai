<?php

use App\Model\LikeView;
use App\Model\ActivityLog;
use App\Model\ResellService;
use App\Model\Setting;
use App\Model\Deposit;
use App\Model\UserSetting;
use App\Model\Wallet;
use App\Model\Withdrawal;
use App\Model\Service;
use App\User;
use Carbon\Carbon;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Jenssegers\Agent\Agent;
use Ramsey\Uuid\Uuid;
use App\Model\Bid;
use App\Model\Notification;
use App\Model\Follow;
use App\Model\TopSeller;
use App\Model\BidHistory;
use App\Model\SellService;
use App\Model\ServiceCharge;
use App\Model\Earning;
use App\Model\TransferToken;


function previousMonthName($m){
    $months = [];
    for ($i=$m; $i >= 0; $i--) {
        array_push($months, date('F', strtotime('-'.$i.' Month')));
    }

    return array_reverse($months);
}
function previousYearMonthName(){

    $months = [];
    for ($i=0; $i <12; $i++) {
        array_push($months, Carbon::now()->startOfYear()->addMonth($i)->format('F'));
    }

    return $months;
}

function previousDayName(){
    $days = array();
    for ($i = 1; $i < 8; $i++) {
        array_push($days,Carbon::now()->startOfWeek()->subDays($i)->format('l'));
    }

    return array_reverse($days);
}
function previousMonthDateName(){
    $days = array();
    for ($i = 0; $i < 30; $i++) {
        array_push($days,Carbon::now()->startOfMonth()->addDay($i)->format('d-M'));
    }

    return $days;
}


/**
 * @param null $array
 * @return array|bool
 */
function allsetting($array = null)
{
    if (!isset($array[0])) {
        $allsettings = Setting::get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } elseif (is_array($array)) {
        $allsettings = Setting::whereIn('slug', $array)->get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } else {
        $allsettings = Setting::where(['slug' => $array])->first();
        if ($allsettings) {
            $output = $allsettings->value;
            return $output;
        }
        return false;
    }
}

/**
 * @param null $input
 * @return array|mixed
 */

function addActivityLog($action,$source,$ip_address,$location){
    $return = false;
    if (ActivityLog::create(['action'=>$action,'user_id'=>$source,'ip_address'=>$ip_address,'location'=>$location]))
        $return = true;
    return $return;


}
function calculateFees($amount, $feeMethod, $feePercentage, $feeFixed)
{
    try {
        if ($feeMethod == 1) {
            return customNumberFormat($feeFixed);
        } elseif ($feeMethod == 2) {
            return customNumberFormat(bcdiv(bcmul($feePercentage, $amount), 100));
        } elseif ($feeMethod == 3) {
            return customNumberFormat(bcadd($feeFixed, bcdiv(bcmul($feePercentage, $amount), 100)));
        } else {
            return 0;
        }
    } catch (\Exception $e) {
        return 0;
    }
}
function country($input=null){
    $output = [
        'af' => 'Afghanistan',
        'al' => 'Albania',
        'dz' => 'Algeria',
        'ds' => 'American Samoa',
        'ad' => 'Andorra',
        'ao' => 'Angola',
        'ai' => 'Anguilla',
        'aq' => 'Antarctica',
        'ag' => 'Antigua and Barbuda',
        'ar' => 'Argentina',
        'am' => 'Armenia',
        'aw' => 'Aruba',
        'au' => 'Australia',
        'at' => 'Austria',
        'az' => 'Azerbaijan',
        'bs' => 'Bahamas',
        'bh' => 'Bahrain',
        'bd' => 'Bangladesh',
        'bb' => 'Barbados',
        'by' => 'Belarus',
        'be' => 'Belgium',
        'bz' => 'Belize',
        'bj' => 'Benin',
        'bm' => 'Bermuda',
        'bt' => 'Bhutan',
        'bo' => 'Bolivia',
        'ba' => 'Bosnia and Herzegovina',
        'bw' => 'Botswana',
        'br' => 'Brazil',
        'io' => 'British Indian Ocean Territory',
        'bn' => 'Brunei',
        'bg' => 'Bulgaria',
        'bf' => 'Burkina ',
        'bi' => 'Burundi',
        'kh' => 'Cambodia',
        'cm' => 'Cameroon',
        'ca' => 'Canada',
        'cv' => 'Cape Verde',
        'ky' => 'Cayman Islands',
        'cf' => 'Central African Republic',
        'td' => 'Chad',
        'cl' => 'Chile',
        'cn' => 'China',
        'cx' => 'Christmas Island',
        'cc' => 'Cocos Islands',
        'co' => 'Colombia',
        'km' => 'Comoros',
        'ck' => 'Cook Islands',
        'cr' => 'Costa Rica',
        'hr' => 'Croatia',
        'cu' => 'Cuba',
        'cy' => 'Cyprus',
        'cz' => 'Czech Republic',
        'cg' => 'Congo',
        'dk' => 'Denmark',
        'dj' => 'Djibouti',
        'dm' => 'Dominica',
        'tp' => 'East Timor',
        'ec' => 'Ecuador',
        'eg' => 'Egypt',
        'sv' => 'El Salvador',
        'gq' => 'Equatorial Guinea',
        'er' => 'Eritrea',
        'ee' => 'Estonia',
        'et' => 'Ethiopia',
        'fk' => 'Falkland Islands',
        'fo' => 'Faroe ',
        'fj' => 'Fiji',
        'fi' => 'Finland',
        'fr' => 'France',
        'pf' => 'French Polynesia',
        'ga' => 'Gabon',
        'gm' => 'Gambia',
        'ge' => 'Georgia',
        'de' => 'Germany',
        'gh' => 'Ghana',
        'gi' => 'Gibraltar',
        'gr' => 'Greece',
        'gl' => 'Greenland',
        'gd' => 'Grenada',
        'gu' => 'Guam',
        'gt' => 'Guatemala',
        'gk' => 'Guernsey',
        'gn' => 'Guinea',
        'gw' => 'Guinea-',
        'gy' => 'Guyana',
        'ht' => 'Haiti',
        'hn' => 'Honduras',
        'hk' => 'Hong Kong',
        'hu' => 'Hungary',
        'is' => 'Iceland',
        'in' => 'India',
        'id' => 'Indonesia',
        'ir' => 'Iran',
        'iq' => 'Iraq',
        'ie' => 'Ireland',
        'im' => 'Isle of ',
        'il' => 'Israel',
        'it' => 'Italy',
        'ci' => 'Ivory ',
        'jm' => 'Jamaica',
        'jp' => 'Japan',
        'je' => 'Jersey',
        'jo' => 'Jordan',
        'kz' => 'Kazakhstan',
        'ke' => 'Kenya',
        'ki' => 'Kiribati',
        'kp' => 'North Korea',
        'kr' => 'South Korea',
        'xk' => 'Kosovo',
        'kw' => 'Kuwait',
        'kg' => 'Kyrgyzstan',
        'la' => 'Laos',
        'lv' => 'Latvia',
        'lb' => 'Lebanon',
        'ls' => 'Lesotho',
        'lr' => 'Liberia',
        'ly' => 'Libya',
        'li' => 'Liechtenstein',
        'lt' => 'Lithuania',
        'lu' => 'Luxembourg',
        'mo' => 'Macau',
        'mk' => 'Macedonia',
        'mg' => 'Madagascar',
        'mw' => 'Malawi',
        'my' => 'Malaysia',
        'mv' => 'Maldives',
        'ml' => 'Mali',
        'mt' => 'Malta',
        'mh' => 'Marshall Islands',
        'mr' => 'Mauritania',
        'mu' => 'Mauritius',
        'ty' => 'Mayotte',
        'mx' => 'Mexico',
        'fm' => 'Micronesia',
        'md' => 'Moldova, Republic of',
        'mc' => 'Monaco',
        'mn' => 'Mongolia',
        'me' => 'Montenegro',
        'ms' => 'Montserrat',
        'ma' => 'Morocco',
        'mz' => 'Mozambique',
        'mm' => 'Myanmar',
        'na' => 'Namibia',
        'nr' => 'Nauru',
        'np' => 'Nepal',
        'nl' => 'Netherlands',
        'an' => 'Netherlands Antilles',
        'nc' => 'New Caledonia',
        'nz' => 'New Zealand',
        'ni' => 'Nicaragua',
        'ne' => 'Niger',
        'ng' => 'Nigeria',
        'nu' => 'Niue',
        'mp' => 'Northern Mariana Islands',
        'no' => 'Norway',
        'om' => 'Oman',
        'pk' => 'Pakistan',
        'pw' => 'Palau',
        'ps' => 'Palestine',
        'pa' => 'Panama',
        'pg' => 'Papua New Guinea',
        'py' => 'Paraguay',
        'pe' => 'Peru',
        'ph' => 'Philippines',
        'pn' => 'Pitcairn',
        'pl' => 'Poland',
        'pt' => 'Portugal',
        'qa' => 'Qatar',
        're' => 'Reunion',
        'ro' => 'Romania',
        'ru' => 'Russian',
        'rw' => 'Rwanda',
        'kn' => 'Saint Kitts and Nevis',
        'lc' => 'Saint Lucia',
        'vc' => 'Saint Vincent and the Grenadines',
        'ws' => 'Samoa',
        'sm' => 'San Marino',
        'st' => 'Sao Tome and ',
        'sa' => 'Saudi Arabia',
        'sn' => 'Senegal',
        'rs' => 'Serbia',
        'sc' => 'Seychelles',
        'sl' => 'Sierra ',
        'sg' => 'Singapore',
        'sk' => 'Slovakia',
        'si' => 'Slovenia',
        'sb' => 'Solomon Islands',
        'so' => 'Somalia',
        'za' => 'South Africa',
        'es' => 'Spain',
        'lk' => 'Sri Lanka',
        'sd' => 'Sudan',
        'sr' => 'Suriname',
        'sj' => 'Svalbard and Jan Mayen ',
        'sz' => 'Swaziland',
        'se' => 'Sweden',
        'ch' => 'Switzerland',
        'sy' => 'Syria',
        'tw' => 'Taiwan',
        'tj' => 'Tajikistan',
        'tz' => 'Tanzania',
        'th' => 'Thailand',
        'tg' => 'Togo',
        'tk' => 'Tokelau',
        'to' => 'Tonga',
        'tt' => 'Trinidad and Tobago',
        'tn' => 'Tunisia',
        'tr' => 'Turkey',
        'tm' => 'Turkmenistan',
        'tc' => 'Turks and Caicos Islands',
        'tv' => 'Tuvalu',
        'ug' => 'Uganda',
        'ua' => 'Ukraine',
        'ae' => 'United Arab Emirates',
        'gb' => 'United ',
        'uy' => 'Uruguay',
        'uz' => 'Uzbekistan',
        'vu' => 'Vanuatu',
        'va' => 'Vatican City State',
        've' => 'Venezuela',
        'vn' => 'Vietnam',
        'vi' => 'Virgin Islands (U.S.)',
        'wf' => 'Wallis and Futuna Islands',
        'eh' => 'Western ',
        'ye' => 'Yemen',
        'zm' => 'Zambia',
        'zw' => 'Zimbabwe'
    ];

    if (is_null($input)) {
        return $output;
    } else {

        return $output[$input];
    }
}

function country_code($input=null){
    $output = [
        '44' => 'UK (+44)',
        '1' => 'USA (+1)',
        '213' => 'Algeria (+213)',
        '376' => 'Andorra (+376)',
        '244' => 'Angola (+244)',
        '1264' => 'Anguilla (+1264)',
        '1268' => 'Antigua & Barbuda (+1268)',
        '54' => 'Argentina (+54)',
        '374' => 'Armenia (+374)',
        '297' => 'Aruba (+297)',
        '61' => 'Australia (+61)',
        '43' => 'Austria (+43)',
        '994' => 'Azerbaijan (+994)',
        '1242' => 'Bahamas (+1242)',
        '973' => 'Bahrain (+973)',
        '880' => 'Bangladesh (+880)',
        '1246' => 'Barbados (+1246)',
        '375' => 'Belarus (+375)',
        '32' => 'Belgium (+32)',
        '501' => 'Belize (+501)',
        '229' => 'Benin (+229)',
        '1441' => 'Bermuda (+1441)',
        '975' => 'Bhutan (+975)',
        '591' => 'Bolivia (+591)',
        '387' => 'Bosnia Herzegovina (+387)',
        '267' => 'Botswana (+267)',
        '55' => 'Brazil (+55)',
        '673' => 'Brunei (+673)',
        '359' => 'Bulgaria (+359)',
        '226' => 'Burkina Faso (+226)',
        '257' => 'Burundi (+257)',
        '855' => 'Cambodia (+855)',
        '237' => 'Cameroon (+237)',
        '1' => 'Canada (+1)',
        '238' => 'Cape Verde Islands (+238)',
        '1345' => 'Cayman Islands (+1345)',
        '236' => 'Central African Republic (+236)',
        '56' => 'Chile (+56)',
        '86' => 'China (+86)',
        '57' => 'Colombia (+57)',
        '269' => 'Comoros (+269)',
        '242' => 'Congo (+242)',
        '682' => 'Cook Islands (+682)',
        '506' => 'Costa Rica (+506)',
        '385' => 'Croatia (+385)',
        '53' => 'Cuba (+53)',
        '90392' => 'Cyprus North (+90392)',
        '357' => 'Cyprus South (+357)',
        '42' => 'Czech Republic (+42)',
        '45' => 'Denmark (+45)',
        '253' => 'Djibouti (+253)',
        '1809' => 'Dominica (+1809)',
        '1809' => 'Dominican Republic (+1809)',
        '593' => 'Ecuador (+593)',
        '20' => 'Egypt (+20)',
        '503' => 'El Salvador (+503)',
        '240' => 'Equatorial Guinea (+240)',
        '291' => 'Eritrea (+291)',
        '372' => 'Estonia (+372)',
        '251' => 'Ethiopia (+251)',
        '500' => 'Falkland Islands (+500)',
        '298' => 'Faroe Islands (+298)',
        '679' => 'Fiji (+679)',
        '358' => 'Finland (+358)',
        '33' => 'France (+33)',
        '594' => 'French Guiana (+594)',
        '689' => 'French Polynesia (+689)',
        '241' => 'Gabon (+241)',
        '220' => 'Gambia (+220)',
        '7880' => 'Georgia (+7880)',
        '49' => 'Germany (+49)',
        '233' => 'Ghana (+233)',
        '350' => 'Gibraltar (+350)',
        '30' => 'Greece (+30)',
        '299' => 'Greenland (+299)',
        '1473' => 'Grenada (+1473)',
        '590' => 'Guadeloupe (+590)',
        '671' => 'Guam (+671)',
        '502' => 'Guatemala (+502)',
        '224' => 'Guinea (+224)',
        '245' => 'Guinea - Bissau (+245)',
        '592' => 'Guyana (+592)',
        '509' => 'Haiti (+509)',
        '504' => 'Honduras (+504)',
        '852' => 'Hong Kong (+852)',
        '36' => 'Hungary (+36)',
        '354' => 'Iceland (+354)',
        '91' => 'India (+91)',
        '62' => 'Indonesia (+62)',
        '98' => 'Iran (+98)',
        '964' => 'Iraq (+964)',
        '353' => 'Ireland (+353)',
        '972' => 'Israel (+972)',
        '39' => 'Italy (+39)',
        '1876' => 'Jamaica (+1876)',
        '81' => 'Japan (+81)',
        '962' => 'Jordan (+962)',
        '7' => 'Kazakhstan (+7)',
        '254' => 'Kenya (+254)',
        '686' => 'Kiribati (+686)',
        '850' => 'Korea North (+850)',
        '82' => 'Korea South (+82)',
        '965' => 'Kuwait (+965)',
        '996' => 'Kyrgyzstan (+996)',
        '856' => 'Laos (+856)',
        '371' => 'Latvia (+371)',
        '961' => 'Lebanon (+961)',
        '266' => 'Lesotho (+266)',
        '231' => 'Liberia (+231)',
        '218' => 'Libya (+218)',
        '417' => 'Liechtenstein (+417)',
        '370' => 'Lithuania (+370)',
        '352' => 'Luxembourg (+352)',
        '853' => 'Macao (+853)',
        '389' => 'Macedonia (+389)',
        '261' => 'Madagascar (+261)',
        '265' => 'Malawi (+265)',
        '60' => 'Malaysia (+60)',
        '960' => 'Maldives (+960)',
        '223' => 'Mali (+223)',
        '356' => 'Malta (+356)',
        '692' => 'Marshall Islands (+692)',
        '596' => 'Martinique (+596)',
        '222' => 'Mauritania (+222)',
        '269' => 'Mayotte (+269)',
        '52' => 'Mexico (+52)',
        '691' => 'Micronesia (+691)',
        '373' => 'Moldova (+373)',
        '377' => 'Monaco (+377)',
        '976' => 'Mongolia (+976)',
        '1664' => 'Montserrat (+1664)',
        '212' => 'Morocco (+212)',
        '258' => 'Mozambique (+258)',
        '95' => 'Myanmar (+95)',
        '264' => 'Namibia (+264)',
        '674' => 'Nauru (+674)',
        '977' => 'Nepal (+977)',
        '31' => 'Netherlands (+31)',
        '687' => 'New Caledonia (+687)',
        '64' => 'New Zealand (+64)',
        '505' => 'Nicaragua (+505)',
        '227' => 'Niger (+227)',
        '234' => 'Nigeria (+234)',
        '683' => 'Niue (+683)',
        '672' => 'Norfolk Islands (+672)',
        '670' => 'Northern Marianas (+670)',
        '47' => 'Norway (+47)',
        '968' => 'Oman (+968)',
        '680' => 'Palau (+680)',
        '507' => 'Panama (+507)',
        '675' => 'Papua New Guinea (+675)',
        '595' => 'Paraguay (+595)',
        '51' => 'Peru (+51)',
        '63' => 'Philippines (+63)',
        '48' => 'Poland (+48)',
        '351' => 'Portugal (+351)',
        '1787' => 'Puerto Rico (+1787)',
        '974' => 'Qatar (+974)',
        '262' => 'Reunion (+262)',
        '40' => 'Romania (+40)',
        '7' => 'Russia (+7)',
        '250' => 'Rwanda (+250)',
        '378' => 'San Marino (+378)',
        '239' => 'Sao Tome & Principe (+239)',
        '966' => 'Saudi Arabia (+966)',
        '221' => 'Senegal (+221)',
        '381' => 'Serbia (+381)',
        '248' => 'Seychelles (+248)',
        '232' => 'Sierra Leone (+232)',
        '65' => 'Singapore (+65)',
        '421' => 'Slovak Republic (+421)',
        '386' => 'Slovenia (+386)',
        '677' => 'Solomon Islands (+677)',
        '252' => 'Somalia (+252)',
        '27' => 'South Africa (+27)',
        '34' => 'Spain (+34)',
        '94' => 'Sri Lanka (+94)',
        '290' => 'St. Helena (+290)',
        '1869' => 'St. Kitts (+1869)',
        '1758' => 'St. Lucia (+1758)',
        '249' => 'Sudan (+249)',
        '597' => 'Suriname (+597)',
        '268' => 'Swaziland (+268)',
        '46' => 'Sweden (+46)',
        '41' => 'Switzerland (+41)',
        '963' => 'Syria (+963)',
        '886' => 'Taiwan (+886)',
        '7' => 'Tajikstan (+7)',
        '66' => 'Thailand (+66)',
        '228' => 'Togo (+228)',
        '676' => 'Tonga (+676)',
        '1868' => 'Trinidad & Tobago (+1868)',
        '216' => 'Tunisia (+216)',
        '90' => 'Turkey (+90)',
        '7' => 'Turkmenistan (+7)',
        '993' => 'Turkmenistan (+993)',
        '1649' => 'Turks & Caicos Islands (+1649)',
        '688' => 'Tuvalu (+688)',
        '256' => 'Uganda (+256)',
        '380' => 'Ukraine (+380)',
        '971' => 'United Arab Emirates (+971)',
        '598' => 'Uruguay (+598)',
        '7' => 'Uzbekistan (+7)',
        '678' => 'Vanuatu (+678)',
        '379' => 'Vatican City (+379)',
        '58' => 'Venezuela (+58)',
        '84' => 'Vietnam (+84)',
        '84' => 'Virgin Islands - British (+1284)',
        '84' => 'Virgin Islands - US (+1340)',
        '681' => 'Wallis & Futuna (+681)',
        '969' => 'Yemen (North)(+969)',
        '967' => 'Yemen (South)(+967)',
        '260' => 'Zambia (+260)',
        '263' => 'Zimbabwe (+263)',
    ];

    if (is_null($input)) {
        return $output;
    } else {

        return $output[$input];
    }
}




/**
 * @param $a
 * @return string
 */
//Random string
function randomString($a)
{
    $x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}

/**
 * @param int $a
 * @return string
 */
// random number
function randomNumber($a = 6)
{
    $x = '123456789';
    $c = strlen($x) - 1;
    $z = '';
    for ($i = 0; $i < $a; $i++) {
        $y = rand(0, $c);
        $z .= substr($x, $y, 1);
    }
    return $z;
}

//use array key for validator
/**
 * @param $array
 * @param string $seperator
 * @param array $exception
 * @return string
 */
function arrKeyOnly($array, $seperator = ',', $exception = [])
{
    $string = '';
    $sep = '';
    foreach ($array as $key => $val) {
        if (in_array($key, $exception) == false) {
            $string .= $sep . $key;
            $sep = $seperator;
        }
    }
    return $string;
}

/**
 * @param $img
 * @param $path
 * @param null $user_file_name
 * @param null $width
 * @param null $height
 * @return bool|string
 */
function uploadInStorage($img, $path, $user_file_name = null, $width = null, $height = null)
{

    if (!file_exists($path)) {

        mkdir($path, 777, true);
    }

    if (isset($user_file_name) && $user_file_name != "" && file_exists($path . $user_file_name)) {
        unlink($path . $user_file_name);
    }
    // saving image in target path
    $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
    $imgPath = public_path($path . $imgName);
    // making image
    $makeImg = \Intervention\Image\Image::make($img)->orientate();
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $imgName;
    }
    return false;
}

function uploadimage($img, $path, $user_file_name = null, $width = null, $height = null)
{

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if (isset($user_file_name) && $user_file_name != "" && file_exists($path . $user_file_name)) {
        unlink($path . $user_file_name);
    }
    // saving image in target path
    $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
    $imgPath = public_path($path . $imgName);
    // making image
    $makeImg = Image::make($img)->orientate();
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        $makeImg->fit($width, $height);
    }
    if ($makeImg->save($imgPath)) {
        return $imgName;
    }
    return false;
}

/**
 * @param $path
 * @param $file_name
 */
function removeImage($path, $file_name)
{
    if (isset($file_name) && $file_name != "" && file_exists($path . $file_name)) {
        unlink($path . $file_name);
    }
}

//Advertisement image path
/**
 * @return string
 */
function path_image()
{
    return IMG_VIEW_PATH;
}

/**
 * @return string
 */
function upload_path()
{
    return 'uploads/';
}



/**
 * @param $file
 * @param $destinationPath
 * @param null $oldFile
 * @return bool|string
 */
function uploadFile($new_file, $path, $old_file_name = null, $width = null, $height = null)
{
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, true);
    }
    if (isset($old_file_name) && $old_file_name != "" && file_exists($path . substr($old_file_name, strrpos($old_file_name, '/') + 1))) {

        unlink($path . '/' . substr($old_file_name, strrpos($old_file_name, '/') + 1));
    }

    $input['imagename'] = uniqid() . time() . '.' . $new_file->getClientOriginalExtension();
    $imgPath = public_path($path . $input['imagename']);

    $makeImg = Image::make($new_file);
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $input['imagename'];
    }
    return false;

}

function containsWord($str, $word)
{
    return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
}

/**
 * @param $destinationPath
 * @param $file
 */
function deleteFile($destinationPath, $file)
{
    if (isset($file) && $file != "" && file_exists($destinationPath . $file)) {
        unlink($destinationPath . $file);
    }
}

//function for getting client ip address
/**
 * @return mixed|string
 */
function get_clientIp()
{
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
}

/**
 * @return array|bool
 */
function language()
{
    $lang = [];
    $path = base_path('resources/lang');
    foreach (glob($path . '/*.json') as $file) {
        $langName = basename($file, '.json');
        $lang[$langName] = $langName;
    }
    return empty($lang) ? false : $lang;
}

/**
 * @param null $input
 * @return array|mixed
 */
function langName($input = null)
{
    $output = [
        'en' => 'English',
        'es' => 'Spanish',
        'ja' => 'Japanese',
        'zh' => 'Chinese',
        'ko' => 'Korean'
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}



if (!function_exists('settings')) {

    function settings($keys = null)
    {
        if ($keys && is_array($keys)) {
            return Setting::whereIn('slug', $keys)->pluck('value', 'slug')->toArray();
        } elseif ($keys && is_string($keys)) {
            $setting = Setting::where('slug', $keys)->first();
            return empty($setting) ? false : $setting->value;
        }
        return Setting::pluck('value', 'slug')->toArray();
    }
}

function landingPageImage($index,$static_path){
    if (settings($index)){
        return asset(path_image()).'/'.settings($index);
    }
    return asset('landing').'/'.$static_path;
}

function userSettings($keys = null){
    if ($keys && is_array($keys)) {
        return UserSetting::whereIn('slug', $keys)->pluck('value', 'slug')->toArray();
    } elseif ($keys && is_string($keys)) {
        $setting = UserSetting::where('slug', $keys)->first();
        return empty($setting) ? false : $setting->value;
    }
    return UserSetting::pluck('value', 'slug')->toArray();
}
//Call this in every function
/**
 * @param $lang
 */
function set_lang($lang)
{
    $default = settings('lang');
    $lang = strtolower($lang);
    $languages = language();
    if (in_array($lang, $languages)) {
        app()->setLocale($lang);
    } else {
        if (isset($default)) {
            $lang = $default;
            app()->setLocale($lang);
        }
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function langflug($input = null)
{

    $output = [
        'en' => '<i class="flag-icon flag-icon-us"></i> ',
        'fr' => '<i class="flag-icon flag-icon-fr"></i>',
        'it' => '<i class="flag-icon flag-icon-it"></i>',
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


//find odd even
/**
 * @param $number
 * @return string
 */
function oddEven($number)
{
    if ($number % 2 == 0) {
        return 'even';
    } else {
        return 'odd';
    }
}

function convert_currency($amount, $to = 'USD', $from = 'USD')
{
    $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
    $json = file_get_contents($url); //,FALSE,$ctx);
    $jsondata = json_decode($json, TRUE);

    return bcmul($amount, $jsondata[$to],8);
}

// fees calculation
function calculate_fees($amount, $method)
{
    $settings = allsetting();

    try {
        if ($method == SEND_FEES_FIXED) {
            return $settings['send_fees_fixed'];
        } elseif ($method == SEND_FEES_PERCENTAGE) {
            return ($settings['send_fees_percentage'] * $amount) / 100;
        }  else {
            return 0;
        }
    } catch (\Exception $e) {
        return 0;
    }
}

/**
 * @param null $message
 * @return string
 */
function getToastrMessage($message = null)
{
    if (!empty($message)) {
        $message = explode(':', $message);
        if (isset($message[1])) {
            $data = 'toastr.' . $message[0] . '("' . $message[1] . '")';
        } else {
            $data = "toastr.error(' write ( errorType:message ) ')";
        }

        return '<script>' . $data . '</script>';

    }

}

function getUserBalance($user_id){
    $wallets = Wallet::where('user_id',$user_id);

    $data['available_coin'] = $wallets->sum('balance');
    $data['available_used'] = $data['available_coin']*settings('coin_price');
    $data['pending_withdrawal_coin'] = 0;
    $data['pending_withdrawal_usd'] = 0;
    return $data;
}

// total withdrawal
function total_withdrawal($user_id)
{
    $total = 0;
    $withdrawal = Withdrawal::join('wallets', 'wallets.id', '=','withdrawals.wallet_id')
        ->where('wallets.user_id', $user_id)
        ->where('withdrawals.status',STATUS_SUCCESS)
        ->get();
    if (isset($withdrawal[0])) {
        $total = $withdrawal->sum('amount');
    }

    return $total;
}
// total deposit
function total_deposit($user_id)
{
    $total = 0;
    $deposit = Deposit::join('wallets', 'wallets.id', '=','deposits.receiver_wallet_id')
        ->where('wallets.user_id', $user_id)
        ->where('deposits.status',STATUS_SUCCESS)
        ->get();
    if (isset($deposit[0])) {
        $total = $deposit->sum('amount');
    }

    return $total;
}

function getActionHtml($list_type,$user_id,$item){

    $html = '<div class="activity-icon"><ul>';
    if ($list_type == 'active_users'){
        $html .='
               <li><a title="'.__('View').'" href="'.route('admin_user_profile').'?id='.encrypt($user_id).'&type=view" class="user-two"><span class="user-list-actions-icon"><i class="fas fa-eye"></i></span></a></li>
               <li><a title="'.__('Edit').'" href="'.route('admin_user_edit').'?id='.encrypt($user_id).'&type=edit" class="user-two"><span class="user-list-actions-icon"><i class="fas fa-pencil-alt"></i></span></a></li>
               <li>'.suspend_html('admin_user_suspend',encrypt($user_id)).'</li>';
                if(!empty($item->google2fa_secret)) {
                    $html .='<li>'.gauth_html('admin_user_remove_gauth',encrypt($user_id)).'</li>';
                }
                $html .='<li>'.delete_html('admin_user_delete',encrypt($user_id)).'</li>';

    } elseif ($list_type == 'suspend_user') {
        $html .='<li><a title="'.__('View').'" href="'.route('admin_user_edit').'?id='.encrypt($user_id).'&type=view" class="view"><span class="user-list-actions-icon"><i class="fas fa-eye"></i></span></a></li>
          <li><a data-toggle="tooltip" title="Activate" href="'.route('admin_user_active',encrypt($user_id)).'" class="check"><span class="user-list-actions-icon"><i class="fas fa-check"></i></span></a></li>
         ';

    } elseif($list_type == 'deleted_user') {
        $html .='<li><a title="'.__('View').'" href="'.route('admin_user_edit').'?id='.encrypt($user_id).'&type=view" class="view"><span class="user-list-actions-icon"><i class="fas fa-eye"></i></span></a></li>
          <li><a data-toggle="tooltip" title="Activate" href="'.route('admin_user_active',encrypt($user_id)).'" class="check"><span class="user-list-actions-icon"><i class="fas fa-check"></i></span></a></li>
         ';

    } elseif($list_type == 'email_pending') {
        $html .=' <li><a data-toggle="tooltip" title="Email verify" href="'.route('admin_user_email_verify',encrypt($user_id)).'" class="check"><span class="user-list-actions-icon"><i class="fas fa-check"></i></span></a></li>';

    }
    $html .='</ul></div>';
    return $html;
}

// Html render
/**
 * @param $route
 * @param $id
 * @return string
 */
function edit_html($route, $id)
{
    $html = '<li class="viewuser"><a title="'.__('Edit').'" href="' . route($route, encrypt($id)) . '"><i class="fa fa-pencil"></i></a></li>';
    return $html;
}


/**
 * @param $route
 * @param $id
 * @return string
 * @throws Exception
 */

function receipt_view_html($image_link)
{
    $num = random_int(1111111111,9999999999999);
    $html = '<div class="deleteuser"><a title="'.__('Bank receipt').'" href="#view_' . $num . '" data-toggle="modal">Bank Deposit</a> </div>';
    $html .= '<div id="view_' . $num . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-lg">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Bank receipt') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><img src="'.$image_link.'" alt=""></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function delete_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('delete').'" href="#delete_' . decrypt($id) . '" data-toggle="modal"><span class="user-list-actions-icon"><i class="fas fa-user-times"></i></span></a> </li>';
    $html .= '<div id="delete_' . decrypt($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Delete') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to delete ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}


function suspend_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('Suspend').'" href="#suspends_' . decrypt($id) . '" data-toggle="modal"><span class="user-list-actions-icon"><i class="fas fa-user-minus"></i></span></a> </li>';
    $html .= '<div id="suspends_' . decrypt($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Suspend') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to suspend ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function active_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('Active').'" href="#active_' . decrypt($id) . '" data-toggle="modal"><span class="flaticon-delete"></span></a> </li>';
    $html .= '<div id="active_' . decrypt($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Delete') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Active ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-success" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function accept_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('Accept').'" href="#accept_' . decrypt($id) . '" data-toggle="modal"><span class="accept-reject-btn bg-success"><i class="fas fa-check"></i>
    </span></a> </li>';
    $html .= '<div id="accept_' . decrypt($id) . '" class="modal fade" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Accept') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Accept ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-success" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function reject_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="'.__('Reject').'" href="#reject_' . decrypt($id) . '" data-toggle="modal"><span class="accept-reject-btn bg-danger"><i class="fas fa-trash-alt"></i>
    </span></a> </li>';
    $html .= '<div id="reject_' . decrypt($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Reject') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Reject ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
/**
 * @param $route
 * @param $id
 * @return string
 */
function ChangeStatus($route, $id)
{
    $html = '<li class=""><a href="#status_' . $id . '" data-toggle="modal"><i class="fa fa-ban"></i></a> </li>';
    $html .= '<div id="status_' . $id . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Block') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Block this product ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

/**
 * @param $route
 * @param $id
 * @return string
 */
function BlockStatusChange($route, $id)
{   $html = '<ul class="activity-menu">';
    $html .= '<li class=" "><a title="'.__('Status change').'" href="#blockuser' . $id . '" data-toggle="modal"><i class="fa fa-check"></i></a> </li>';
    $html .= '<div id="blockuser' . $id . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Block') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to Unblock this product ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-success"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</ul>';

    return $html;
}

/**
 * @param $route
 * @param $param
 * @return string
 */
function cancelSentItem($route,$param)
{
    $html  = '<li class=""><a title="'.__('Cancel').'" class="delete" href="#blockuser' . $param . '" data-toggle="modal"><i class="fa fa-remove"></i></a> </li>';
    $html .= '<div id="blockuser' . $param . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Cancel') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to cancel this product ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-success"href="' . route($route).$param. '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';


    return $html;
}

//status search
/**
 * @param $keyword
 * @return array
 */
function status_search($keyword)
{
    $st = [];
    if (strpos('_active', strtolower($keyword)) != false) {
        array_push($st, STATUS_SUCCESS);
    }
    if (strpos('_pending', strtolower($keyword)) != false) {
        array_push($st, STATUS_PENDING);
    }
    if (strpos('_inactive', strtolower($keyword)) != false) {
        array_push($st, STATUS_PENDING);
    }

    if (strpos('_deleted', strtolower($keyword)) != false) {
        array_push($st, STATUS_DELETED);
    }
    return $st;
}

function cim_search($keyword)
{

    return $keyword;
}

/**
 * @param $route
 * @param $status
 * @param $id
 * @return string
 */
function statusChange_html($route, $status, $id)
{
    $icon = ($status != STATUS_SUCCESS) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';
    $status_title = ($status != STATUS_SUCCESS) ? statusAction(STATUS_SUCCESS) : statusAction(STATUS_SUSPENDED);
    $html = '';
    $html .= '<a title="'.__('Status change').'" href="' . route($route, encrypt($id)) . '">' . $icon . '<span>' . $status_title . '</span></a> </li>';
    return $html;
}

//exists img search
/**
 * @param $image
 * @param $path
 * @return string
 */
function imageSrc($image, $path)
{

    $return = asset('admin/images/default.jpg');
    if (!empty($image) && file_exists(public_path($path . '/' . $image))) {
        $return = asset($path . '/' . $image);
    }
    return $return;
}
//exists img search
/**
 * @param $image
 * @param $path
 * @return string
 */
function imageSrcUser($image, $path)
{

    $return = asset('user/assets/images/profile/default.png');
    if (!empty($image) && file_exists(public_path($path . '/' . $image))) {
        $return = asset($path . '/' . $image);
    }
    return $return;
}

function imageSrcVerification($image, $path)
{


    $return = asset('/assets/images/default_card.svg');
    if (!empty($image) && file_exists(public_path($path . '/' . $image))) {
        $return = asset($path . '/' . $image);
    }
    return $return;
}

/**
 * @param $title
 */
function title($title)
{
    session(['title' => $title]);
}


/**
 * @param int $length
 * @return string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}





function customNumberFormat($value)
{
    if (is_integer($value)) {
        return number_format($value, 8, '.', '');
    } elseif (is_string($value)) {
        $value = floatval($value);
    }
    $number = explode('.', number_format($value, 10, '.', ''));
    return $number[0] . '.' . substr($number[1], 0, 2);
}

if (!function_exists('max_level')) {
    function max_level()
    {
        $max_level = allsetting('max_affiliation_level');

        return $max_level ? $max_level : 3;
    }

}

if (!function_exists('user_balance')) {
    function user_balance($userId)
    {
        $balance = Wallet::where('user_id', $userId)->sum(DB::raw('balance + referral_balance'));

        return $balance ? $balance : 0;
    }

}

if (!function_exists('visual_number_format'))
{
    function visual_number_format($value)
    {
        if (is_integer($value)) {
            return number_format($value, 2, '.', '');
        } elseif (is_string($value)) {
            $value = floatval($value);
        }
        $number = explode('.', number_format($value, 14, '.', ''));
        $intVal = (int)$value;
        if ($value > $intVal || $value < 0) {
            $intPart = $number[0];
            $floatPart = substr($number[1], 0, 8);
            $floatPart = rtrim($floatPart, '0');
            if (strlen($floatPart) < 2) {
                $floatPart = substr($number[1], 0, 2);
            }
            return $intPart . '.' . $floatPart;
        }
        return $number[0] . '.' . substr($number[1], 0, 2);
    }
}

// comment author name
function comment_author_name($id)
{
    $name = '';
    $user = User::where('id', $id)->first();
    if(isset($user)) {
        $name = $user->first_name.' '.$user->last_name;
    }

    return $name;
}

function gauth_html($route, $id)
{
    $html = '<li class="deleteuser"><a title="' . __('Remove gauth') . '" href="#remove_gauth_' . decrypt($id) . '" data-toggle="modal"><span class=""><img src="'.asset("assets/admin/images/user-management-icons/activity/check-square.svg").'" class="img-fluid" alt=""></span></a> </li>';
    $html .= '<div id="remove_gauth_' . decrypt($id) . '" class="modal fade delete" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Remove Gauth') . '</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>';
    $html .= '<div class="modal-body"><p>' . __('Do you want to remove gauth ?') . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger"href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
if (!function_exists('all_months')) {
    function all_months($val = null)
    {
        $data = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
            11 => 11,
            12 => 12,
        );
        if ($val == null) {
            return $data;
        } else {
            return $data[$val];
        }
    }
}
function custom_number_format($value)
{
    if (is_integer($value)) {
        return number_format($value, 8, '.', '');
    } elseif (is_string($value)) {
        $value = floatval($value);
    }
    $number = explode('.', number_format($value, 14, '.', ''));
    return $number[0] . '.' . substr($number[1], 0, 8);
}

function converts_currency($amountInUsd, $to = 'USDT', $price)
{
    try {
        $array['amount'] = $amountInUsd;

        if ($to == "LTCT"){
            $to = "LTC";
        }


        if ( $to == 'USDT' )
            return $amountInUsd;


        if ( ($price['error'] == "ok") ) {

            $one_coin = $price['result'][$to]['rate_btc']; // dynamic coin rate in btc

            $one_usd = $price['result']['USDT']['rate_btc']; // 1 usd == btc rate

            $total_amount_in_usd = bcmul($one_usd, $amountInUsd,8);

            return custom_number_format(bcdiv($total_amount_in_usd, $one_coin));
        }
    } catch (\Exception $e) {

        return number_format(0, 8);
    }
}


function convert_to_crypt($amountInBTC, $to = 'USDT', $price)
{
    try {
        $coinpayment = new CoinPaymentsAPI();
        $amount = bcdiv($amountInBTC, settings('coin_price'));
        if ( $to == 'USDT' )
            return $amount;

          $price = $coinpayment->GetRates('');
        if ( ($price['error'] == "ok") ) {

            $one_coin = $price['result'][$to]['rate_btc']; // dynamic coin rate in btc
            $one_usd = $price['result']['USDT']['rate_btc']; // 1 usd ==  btc rate

            $total_amount_in_btc = bcmul($one_usd, $amountInBTC);
            $total_amount_in_usd = bcdiv($total_amount_in_btc, $one_usd);

            return custom_number_format(bcmul($total_amount_in_usd, settings('coin_price')));
        }
    } catch (\Exception $e) {
        return custom_number_format(0, 8);
    }
}


//User Activity
function createUserActivity($userId, $action = '', $ip = null, $device = null){
    if ($ip == null) {
        $current_ip = get_clientIp();
    } else {
        $current_ip = $ip;
    }
    if($device == null){
        $agent = new Agent();
        $deviceType = isset($agent) && $agent->isMobile() == true ? 'Mobile' : 'Web';
    }else{
        $deviceType = $device == 1 ?  'Mobile' : 'Web';
    }

    $activity['user_id'] = $userId;
    $activity['action'] = $action;
    $activity['ip_address'] = isset($current_ip) ? $current_ip : '0.0.0.0';
    $activity['source'] = $deviceType;
    $activity['location'] = '';
    ActivityLog::create($activity);
}
// user image
function show_image($id=null, $type)
{
    $img = asset('assets/admin/img/avater.png');
    if ($type =='logo') {
        if (!empty(allsetting('logo'))) {
            $img = asset(path_image().allsetting('logo'));
        } else {
            $img = asset('assets/user/images/logo.svg');
        }
    } elseif($type == 'login_logo') {
        if (!empty(allsetting('login_logo'))) {
            $img = asset(path_image().allsetting('login_logo'));
        } else {
            $img = asset('assets/user/images/logo.svg');
        }
    } else {
        $user = User::where('id',$id)->first();
        if (isset($user) && !empty($user->photo)) {
            $img = asset(IMG_USER_PATH.$user->photo);
        }
    }
    return $img;
}

// get coin payment address
function get_coin_payment_address($coin)
{
    $coin_payment = new CoinPaymentsAPI();
    $address = $coin_payment->GetCallbackAddress($coin);

    if ( isset($address['error']) && ($address['error'] == 'ok') ) {
        return $address['result']['address'];
    } else {
        return false;
    }
}

function colors()
{
    $color = ['Black', 'Green', 'Pink', 'Purple'];
    return $color;
}

function service_status($service_id)
{
    $status = '';
    $service =  Service::whereId($service_id)->first();
    if($service->status == DRAFT) {
     $status = 'Draft';
    }
    elseif ($service->status == ON_ADMIN_APPROVAL) {
        $status = 'On Admin Approval';
    }
    elseif ($service->status == APPROVED) {
        $status = 'Approved';
    }
    elseif ($service->status == PROCESSING) {
        $status = 'Processing';
    }
    elseif ($service->status == SOLD) {
        $status = 'Sold';
    }
    elseif ($service->status == UNSOLD) {
        $status = 'Unsold';
    }
    elseif ($service->status == USER_CANCEL) {
        $status = 'Canceled BY User';
    }
    elseif ($service->status == ADMIN_CANCEL) {
        $status = 'Canceled BY Admin';
    }
    return $status;
}

function coinIconPath()
{
    return 'uploaded_file/coin-icons/';
}

function getImageUrl($filePath)
{
    return asset($filePath);
}

function decryptId($encryptedId)
{
    try {
        $id = decrypt($encryptedId);
    } catch (Exception $e) {
        return ['success' => false];
    }
    return $id;
}

function upload_file($file, $destinationPath)
{
    $image = file_get_contents($file->getRealPath());
    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
    $uploaded = Storage::disk('s3')->put($destinationPath . $fileName, $image);
    if ($uploaded == true) {
        $name = $fileName;
        return $name;
    }
    return false;
}

function wallet_create($coin){
    try {
        $userWallet = [];
        $users = User::with('wallets')->where(['role' => USER_ROLE_USER])->get();
        foreach ($users as $user) {
            $flag = true;
            foreach ($user->wallets as $wallet) {
                if ($wallet->coin_id == $coin) {
                    $flag = false;
                }
            }
            if ($flag) {
                $userWallet[] = [
                    'user_id' => $user->id,
                    'coin_id' => $coin,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'address' => '',
                    'is_primary' => STATUS_SUCCESS,
                ];
            }
        }
        Wallet::insert($userWallet);
        return true;
    }catch (Exception $e){
        return false;
    }

}

function api_service($input = null)
{
    $output = [
        'CoinPaymentsApiService' => 'CoinPaymentsApiService'
    ];
    if ($input == null) {
        return $output;
    } else {
        return $output[$input];
    }
}

function withdrawalFeesMethod($input = null)
{
    $output = [
        WITHDRAWAL_FEES_FIXED => 'WITHDRAWAL FEES FIXED',
        WITHDRAWAL_FEES_PERCENTAGE => 'WITHDRAWAL FEES PERCENTAGE',
        WITHDRAWAL_FEES_BOTH => 'WITHDRAWAL FEES BOTH'
    ];
    if ($input == null) {
        return $output;
    } else {
        return $output[$input];
    }
}

function liked($service_id)
{
    return LikeView::where('user_id', Auth::id())->where('service_id', $service_id)->where('isLike', 1)->count();
}

function categoryUser($cat_id)
{
    return User::where('role', 2)->has('service_sells')->with('service_sells')->whereHas('service_sells', function($query) use($cat_id) {
        $query->where('category_id', $cat_id);
    })->paginate(8);
}

function categoryServices($cat_id)
{
    return Service::where('category_id', $cat_id)->paginate(8);
}

if(!function_exists('categoryServicesSeller'))
{
    function categoryServicesSeller($cat_id, $seller_id) {
        return Service::where('category_id', $cat_id)->where('created_by', $seller_id)->paginate(8);
    }
}

if(!function_exists('checkBoxValue'))
{
    function checkBoxValue($value = null) {
        return $value != null ? 1 : 0;
    }
}

if(!function_exists('coinListUser'))
{
    function coinListUser() {
        return Wallet::with('coin')->where('user_id', Auth::id())->where('status', 1)->get();
    }
}

if(!function_exists('convertToCoin'))
{
    function convertToCoin($price, $coin_type) {

        if($coin_type == 'BTC') {
            return $price / 30;
        }
        else {
            return $price / 20;
        }
    }
}
function getCoinRate($coin){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => env('PRICE_API').$coin.'USDT',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return  $err;
    } else {
        return $response;
    }
}
if(!function_exists('conversionRate'))
{
    function conversionRate($coin_type) {
        $priceInDb = Setting::where('slug', $coin_type.'_price_from_api')->first();
        if(is_null($priceInDb)){
            $priceInDb = new Setting();
            $priceInDb->value = bcdiv(1,json_decode(getCoinRate($coin_type))->price);
            $priceInDb->slug = $coin_type.'_price_from_api';
            $priceInDb->created_at = now();
            $priceInDb->updated_at = now();
            $priceInDb->save();
        }
        if($priceInDb->updated_at->diffInSeconds(Carbon::now()) > 300){
            $price = bcdiv(1,json_decode(getCoinRate($coin_type))->price);
            $priceInDb->value = $price;
            $priceInDb->save();
        }else{
            $price = $priceInDb->value;
        }
       return $price;
    }
}

if(!function_exists('serviceCharge'))
{
    function serviceCharge() {
        $settings = allsetting();
        return $settings['service_charge'];
    }
}

if(!function_exists('serviceChargeBuyer'))
{
    function serviceChargeBuyer($price) {
        $charge = ServiceCharge::where('service_holder', 'buyer')->where('status', STATUS_ACTIVE)->first();
        if($charge->type == SERVICE_CHARGE_FIXED) {
            return $charge->amount;
        }
        elseif ($charge->type == SERVICE_CHARGE_PERCENTAGE) {
            $sp = $charge->type / 100;
            return $price * $sp;
        }
    }
}

if(!function_exists('serviceChargeSeller'))
{
    function serviceChargeSeller($price) {
        $charges = ServiceCharge::where('service_holder', 'seller')->where('status', STATUS_ACTIVE)->first();
        if($charges->type == SERVICE_CHARGE_FIXED) {
            return $charges->amount;
        }
        elseif ($charges->type == SERVICE_CHARGE_PERCENTAGE) {
            $sps = $charges->type / 100;
            return $price * $sps;
        }
    }
}

if(!function_exists('highestBidService'))
{
    function highestBidService($service_id) {
        $bid = Bid::where('service_id', $service_id)->first();
        if(!empty($bid)) {
            $highest_bid = Bid::where('service_id', $service_id)->max('bid_amount');
            return visual_number_format($highest_bid);
        }
        else {
            return 0;
        }

    }
}

if(!function_exists('countBidService'))
{
    function countBidService($service_id) {
        return BidHistory::where('service_id', $service_id)->count();
    }
}

if(!function_exists('findNotification'))
{
    function findNotification($user_id) {

        return Notification::where('user_id', $user_id)->latest()->paginate(5);
    }
}

if(!function_exists('countFollowers'))
{
    function countFollowers($user_id) {

        return Follow::where('following_id', $user_id)->count();
    }
}

if(!function_exists('followServices'))
{
    function followServices($user_id) {

        return Service::where('created_by', $user_id)->paginate(3);
    }
}

if(!function_exists('isFollowed'))
{
    function isFollowed($user_id) {
        return Follow::where('follower_id', Auth::id())->where('following_id', $user_id)->count();
    }
}

if(!function_exists('isTopSeller'))
{
    function isTopSeller($user_id) {
        return TopSeller::where('user_id', $user_id)->count();
    }
}

if(!function_exists('errorHandle'))
{
    function errorHandle($e) {
        if(env('APP_ENV')  == 'production') {
            return __('Something went wrong');
        }
        else {
            return $e;
        }
    }
}

if(!function_exists('generateBidTransaction'))
{
    function generateBidTransaction() {
        $code = 'nft_'.randomString(8);
        if(Bid::where('transaction_id', $code)->exists()){
            return generateBidTransaction();
        }
        else{
            return $code;
        }
    }
}

if(!function_exists('generateBidHistoryTransaction'))
{
    function generateBidHistoryTransaction() {
        $code = 'nft_'.randomString(8);
        if(BidHistory::where('transaction_id', $code)->exists()){
            return generateBidHistoryTransaction();
        }
        else{
            return $code;
        }
    }
}

if(!function_exists('hasPreviousBid'))
{
    function hasPreviousBid($service_id) {
        if (Bid::where('user_id', Auth::id())->where('service_id', $service_id)->exists()) {
            return 1;
        }
        return 0;
    }
}

if(!function_exists('slodOutMessage'))
{
    function slodOutMessage($service_id) {
        $service = Service::whereId($service_id)->first();
        if ($service->available_item <= 0 || $service->status == SOLD) {
            return 1;
        }
        return 0;
    }
}

if(!function_exists('yourbidServiceMessage'))
{
    function yourbidServiceMessage($service_id) {
        $service = Bid::where('service_id', $service_id)->where('user_id', Auth::id())->where('is_sale_bid', 1)->count();
        if ($service != 0) {
            return '<ul class="d-flex justify-content-center align-items-center my-wallet-actions-btn">
                        <li>
                            <a href="'.route('product_view', encrypt($service_id)).'" class="btn btn-success" title="Product Link" target="_blank"><i class="fas fa-link"></i></a>
                        </li>
                        '.resellBtnBid($service_id).'
                    </ul>';
        }
        return '<ul class="d-flex justify-content-center align-items-center my-wallet-actions-btn">
                    <li>
                        <a href="'.route('product_view', encrypt($service_id)).'" class="btn btn-success" title="Product Link" target="_blank"><i class="fas fa-link"></i></a>
                    </li>
                    '.resellBtnBid($service_id).'
                </ul>';
    }
}

if(!function_exists('resellBtnBid'))
{
    function resellBtnBid($service_id) {
        if (!ResellService::where('past_service_id', $service_id)->exists()) {
            return '<li>
                        <button data-toggle="modal" href="#resellModal'.$service_id.'" class="btn btn-info" title="Resell Product"><i class="fas fa-object-ungroup"></i></button>
                    </li>';
        }
    }
}

if(!function_exists('serviceOrigin'))
{
    function serviceOrigin() {
        return Service::select('origin')->groupBy('origin')->orderBy('origin', 'ASC')->where('status', '!=', DRAFT)->get();
    }
}

if(!function_exists('sellServiceEarn'))
{
    function sellServiceEarn() {
        return SellService::sum('service_charge');
    }
}

if(!function_exists('bidServiceEarn'))
{
    function bidServiceEarn() {
        return Bid::where('is_sale_bid', 1)->sum('service_charge');
    }
}

if(!function_exists('SCAmount'))
{
    function SCAmount($holder, $type) {
        $service_charge =  ServiceCharge::select('amount')->where('service_holder', $holder)->where('type', $type)->first();
        return $service_charge->amount;
    }
}

if(!function_exists('SCActive'))
{
    function SCActive($holder, $type) {
        return ServiceCharge::select('amount')->where('service_holder', $holder)->where('type', $type)->where('status', STATUS_ACTIVE)->count();
    }
}

if(!function_exists('coinEarnings'))
{
    function coinEarnings($coin_id) {
        return Earning::where('coin_id', $coin_id)->sum('amount');
    }
}

if(!function_exists('transferHistory'))
{
    function transferHistory($service_id) {
        $service = Service::whereId($service_id)->first();
        if($service->is_resellable == 1) {
            return TransferToken::where('service_id', $service->resell_service_id)->get();
        }else {
            return TransferToken::where('service_id', $service->id)->get();
        }
    }
}

if(!function_exists('transferCount'))
{
    function transferCount($service_id) {
        $service = Service::whereId($service_id)->first();
        if($service->is_resellable == 1) {
            return TransferToken::where('service_id', $service->resell_service_id)->count();
        }else {
            return TransferToken::where('service_id', $service->id)->count();
        }
    }
}

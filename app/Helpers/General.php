<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Http;


if (!function_exists('calculateTextSimilarity')) {
    function calculateTextSimilarity($text1, $text2)
    {
        $encodedText1 = urlencode($text1);
        $encodedText2 = urlencode($text2);

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'X-RapidAPI-Host' => 'twinword-text-similarity-v1.p.rapidapi.com',
            'X-RapidAPI-Key' => 'e89748ff8amsh44ca9e6ae517546p14fd2fjsncf8359047bc0',
        ])->get("https://twinword-text-similarity-v1.p.rapidapi.com/similarity/?text1=$encodedText1&text2=$encodedText2");

        return $response->json();
    }
}
function sendSMS($number, $msg)
{

    try {
        $url = "http://triple-core.ps/sendbulksms.php";
        $fields = [
            'user_name' => env('TRIPLE_USER_NAME','quizzyps'),
            'user_pass' => env('TRIPLE_USER_PASS','Pass@2024'),
            'sender' => env('TRIPLE_SENDER','Quizzy.ps'),
            'mobile' => $number,
            'type' => 0,
            'text' => $msg
        ];
        $response = Http::withoutVerifying()
            ->withOptions(["verify" => false])
            ->get($url, ($fields));
        if ($response->body() != 1001) {
            Log::info('Exception SMS response:' . $response->json() . ' => ' . json_encode($fields));

        }
    } catch (\Exception $exception) {
        Log::info('Exception:' . json_encode($exception));

    }


}

function getImageDimensions($imageUrl)
{
    try {
        $width = 0;
        $height = 0;
        if ($imageUrl) {
            // Get image content from the remote URL
            $imageContent = file_get_contents($imageUrl);

            if ($imageContent === false) {
                // Handle error (unable to fetch image)
                return "Error: Unable to fetch image from $imageUrl";
            }

            // Get image dimensions
            $imageSize = getimagesizefromstring($imageContent);

            if ($imageSize === false) {
                // Handle error (unable to get image dimensions)
                return "Error: Unable to get image dimensions for $imageUrl";
            }

            // Extract width and height from the image size array
            list($width, $height) = $imageSize;

            // Output or use the dimensions as needed

        }
        return ['width' => $width, 'height' => $height];
    } catch (\Exception $e) {
        return ['width' => null, 'height' => null];
    }
}

function checkFileType($url)
{
    if (!$url) {
        return null;
    }

    $response = Http::head($url); // Send a HEAD request to get headers

    if ($response->successful()) {
        $contentType = $response->header('Content-Type');
        $extension = pathinfo($url, PATHINFO_EXTENSION);

        // Check MIME type or file extension
        if (str_starts_with($contentType, 'audio/') || in_array($extension, ['mp3', 'wav', 'ogg'])) {
            return 'audio';
        } elseif (str_starts_with($contentType, 'video/') || in_array($extension, ['mp4', 'avi', 'mkv'])) {
            return 'video';
        } elseif (str_starts_with($contentType, 'image/') || in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            return 'image';
        } else {
            return 'Unknown';
        }
    } else {
        return 'Error';
    }
}


function send_mail($data, $to, $view = "mail")
{
    $from = env('MAIL_FROM_ADDRESS');
    $name_app = env('MAIL_FROM_NAME');

    Mail::send(['text' => $view], $data, function ($message) use ($from, $to, $name_app, $data) {
        $message->to($to, $name_app)->subject($name_app . ' | ' . $data['subject']);
        $message->from($from, $name_app);
    });
    return true;
}

function uploadImage($folder, $image)
{
// Ensure $image is an instance of UploadedFile
    if (!($image instanceof \Illuminate\Http\UploadedFile)) {
        return null; // or throw an exception, depending on your use case
    }
    $image->store('/', $folder);
    $fileName = $image->hashName();
    $path = 'images/' . $folder . '/' . $fileName;
    return $path;
}


function saveArrayImage($folder, $images)
{
    $ImageArray = [];
    foreach ($images as $image) {
        $image_path = uploadImage($folder, $image);
        array_push($ImageArray, $image_path);
    }
    return json_encode($ImageArray);
}

function send_notification_FCM($notification_id, $title, $message, $id, $type)
{


    $access_token = setting('fcm_key', env('FCM_KEY'));

    $URL = 'https://fcm.googleapis.com/fcm/send';
    if (is_array($notification_id))
        $tokens = $notification_id;
    else
        $tokens = [$notification_id];

    $post_data = '{
            "registration_ids" : ' . json_encode($tokens) . ',
            "data" : {
              "body" : "' . $message . '",
              "title" : "' . $title . '",
              "type" : "' . $type . '",
              "id" : "' . $id . '",
              "message" : "' . $message . '",
            },
            "notification" : {
                 "body" : "' . $message . '",
                 "title" : "' . $title . '",
                  "type" : "' . $type . '",
                  "id" : "' . $id . '",
                 "message" : "' . $message . '"

                },

          }';


    $crl = curl_init();

    $header = array();
    $header[] = 'Content-type: application/json';
    $header[] = 'Authorization: ' . $access_token;
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($crl, CURLOPT_URL, $URL);
    curl_setopt($crl, CURLOPT_HTTPHEADER, $header);

    curl_setopt($crl, CURLOPT_POST, true);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

    $rest = curl_exec($crl);

    if ($rest === false) {
        // throw new Exception('Curl error: ' . curl_error($crl));
        // print_r('Curl error: ' . curl_error($crl));
        $result_noti = 0;
    } else {

        $result_noti = 1;
    }

    curl_close($crl);


    return $result_noti;
}
function send_notification_FCM_Topic($topic, $title, $message, $id, $type)
{


    $access_token = setting('fcm_key', env('FCM_KEY'));

    $URL = 'https://fcm.googleapis.com/fcm/send';


    $post_data = '{
            "to" : "/topics/' . $topic . '",
            "data" : {
              "body" : "' . $message . '",
              "title" : "' . $title . '",
              "type" : "' . $type . '",
              "id" : "' . $id . '",
              "message" : "' . $message . '",
            },
            "notification" : {
                 "body" : "' . $message . '",
                 "title" : "' . $title . '",
                  "type" : "' . $type . '",
                  "id" : "' . $id . '",
                 "message" : "' . $message . '"

                },

          }';


    $crl = curl_init();

    $header = array();
    $header[] = 'Content-type: application/json';
    $header[] = 'Authorization: ' . $access_token;
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($crl, CURLOPT_URL, $URL);
    curl_setopt($crl, CURLOPT_HTTPHEADER, $header);

    curl_setopt($crl, CURLOPT_POST, true);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

    $rest = curl_exec($crl);

    if ($rest === false) {
        // throw new Exception('Curl error: ' . curl_error($crl));
        // print_r('Curl error: ' . curl_error($crl));
        $result_noti = 0;
    } else {

        $result_noti = 1;
    }

    curl_close($crl);


    return $result_noti;
}


function getCurrentAdmin($guard = "admin")
{
    return auth($guard)->user();
}

function getFlagIcon($lang)
{
    return $lang == "en" ? 'us' : 'eg';
}

function getAvailLocaleLanguage()
{
//    $availLocale = ['en' => 'English', 'ar' => 'Arabic'];
    $availLocale = [
        'ace' => ['name' => 'Achinese', 'script' => 'Latn', 'native' => 'Aceh', 'regional' => ''],
        'af' => ['name' => 'Afrikaans', 'script' => 'Latn', 'native' => 'Afrikaans', 'regional' => 'af_ZA'],
        'agq' => ['name' => 'Aghem', 'script' => 'Latn', 'native' => 'Aghem', 'regional' => ''],
        'ak' => ['name' => 'Akan', 'script' => 'Latn', 'native' => 'Akan', 'regional' => 'ak_GH'],
        'an' => ['name' => 'Aragonese', 'script' => 'Latn', 'native' => 'aragonés', 'regional' => 'an_ES'],
        'cch' => ['name' => 'Atsam', 'script' => 'Latn', 'native' => 'Atsam', 'regional' => ''],
        'gn' => ['name' => 'Guaraní', 'script' => 'Latn', 'native' => 'Avañe’ẽ', 'regional' => ''],
        'ae' => ['name' => 'Avestan', 'script' => 'Latn', 'native' => 'avesta', 'regional' => ''],
        'ay' => ['name' => 'Aymara', 'script' => 'Latn', 'native' => 'aymar aru', 'regional' => 'ay_PE'],
        'az' => ['name' => 'Azerbaijani (Latin)', 'script' => 'Latn', 'native' => 'azərbaycanca', 'regional' => 'az_AZ'],
        'id' => ['name' => 'Indonesian', 'script' => 'Latn', 'native' => 'Bahasa Indonesia', 'regional' => 'id_ID'],
        'ms' => ['name' => 'Malay', 'script' => 'Latn', 'native' => 'Bahasa Melayu', 'regional' => 'ms_MY'],
        'bm' => ['name' => 'Bambara', 'script' => 'Latn', 'native' => 'bamanakan', 'regional' => ''],
        'jv' => ['name' => 'Javanese (Latin)', 'script' => 'Latn', 'native' => 'Basa Jawa', 'regional' => ''],
        'su' => ['name' => 'Sundanese', 'script' => 'Latn', 'native' => 'Basa Sunda', 'regional' => ''],
        'bh' => ['name' => 'Bihari', 'script' => 'Latn', 'native' => 'Bihari', 'regional' => ''],
        'bi' => ['name' => 'Bislama', 'script' => 'Latn', 'native' => 'Bislama', 'regional' => ''],
        'nb' => ['name' => 'Norwegian Bokmål', 'script' => 'Latn', 'native' => 'Bokmål', 'regional' => 'nb_NO'],
        'bs' => ['name' => 'Bosnian', 'script' => 'Latn', 'native' => 'bosanski', 'regional' => 'bs_BA'],
        'br' => ['name' => 'Breton', 'script' => 'Latn', 'native' => 'brezhoneg', 'regional' => 'br_FR'],
        'ca' => ['name' => 'Catalan', 'script' => 'Latn', 'native' => 'català', 'regional' => 'ca_ES'],
        'ch' => ['name' => 'Chamorro', 'script' => 'Latn', 'native' => 'Chamoru', 'regional' => ''],
        'ny' => ['name' => 'Chewa', 'script' => 'Latn', 'native' => 'chiCheŵa', 'regional' => ''],
        'kde' => ['name' => 'Makonde', 'script' => 'Latn', 'native' => 'Chimakonde', 'regional' => ''],
        'sn' => ['name' => 'Shona', 'script' => 'Latn', 'native' => 'chiShona', 'regional' => ''],
        'co' => ['name' => 'Corsican', 'script' => 'Latn', 'native' => 'corsu', 'regional' => ''],
        'cy' => ['name' => 'Welsh', 'script' => 'Latn', 'native' => 'Cymraeg', 'regional' => 'cy_GB'],
        'da' => ['name' => 'Danish', 'script' => 'Latn', 'native' => 'dansk', 'regional' => 'da_DK'],
        'se' => ['name' => 'Northern Sami', 'script' => 'Latn', 'native' => 'davvisámegiella', 'regional' => 'se_NO'],
        'de' => ['name' => 'German', 'script' => 'Latn', 'native' => 'Deutsch', 'regional' => 'de_DE'],
        'luo' => ['name' => 'Luo', 'script' => 'Latn', 'native' => 'Dholuo', 'regional' => ''],
        'nv' => ['name' => 'Navajo', 'script' => 'Latn', 'native' => 'Diné bizaad', 'regional' => ''],
        'dua' => ['name' => 'Duala', 'script' => 'Latn', 'native' => 'duálá', 'regional' => ''],
        'et' => ['name' => 'Estonian', 'script' => 'Latn', 'native' => 'eesti', 'regional' => 'et_EE'],
        'na' => ['name' => 'Nauru', 'script' => 'Latn', 'native' => 'Ekakairũ Naoero', 'regional' => ''],
        'guz' => ['name' => 'Ekegusii', 'script' => 'Latn', 'native' => 'Ekegusii', 'regional' => ''],
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
        'en-AU' => ['name' => 'Australian English', 'script' => 'Latn', 'native' => 'Australian English', 'regional' => 'en_AU'],
        'en-GB' => ['name' => 'British English', 'script' => 'Latn', 'native' => 'British English', 'regional' => 'en_GB'],
        'en-CA' => ['name' => 'Canadian English', 'script' => 'Latn', 'native' => 'Canadian English', 'regional' => 'en_CA'],
        'en-US' => ['name' => 'U.S. English', 'script' => 'Latn', 'native' => 'U.S. English', 'regional' => 'en_US'],
        'es' => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
        'eo' => ['name' => 'Esperanto', 'script' => 'Latn', 'native' => 'esperanto', 'regional' => ''],
        'eu' => ['name' => 'Basque', 'script' => 'Latn', 'native' => 'euskara', 'regional' => 'eu_ES'],
        'ewo' => ['name' => 'Ewondo', 'script' => 'Latn', 'native' => 'ewondo', 'regional' => ''],
        'ee' => ['name' => 'Ewe', 'script' => 'Latn', 'native' => 'eʋegbe', 'regional' => ''],
        'fil' => ['name' => 'Filipino', 'script' => 'Latn', 'native' => 'Filipino', 'regional' => 'fil_PH'],
        'fr' => ['name' => 'French', 'script' => 'Latn', 'native' => 'français', 'regional' => 'fr_FR'],
        'fr-CA' => ['name' => 'Canadian French', 'script' => 'Latn', 'native' => 'français canadien', 'regional' => 'fr_CA'],
        'fy' => ['name' => 'Western Frisian', 'script' => 'Latn', 'native' => 'frysk', 'regional' => 'fy_DE'],
        'fur' => ['name' => 'Friulian', 'script' => 'Latn', 'native' => 'furlan', 'regional' => 'fur_IT'],
        'fo' => ['name' => 'Faroese', 'script' => 'Latn', 'native' => 'føroyskt', 'regional' => 'fo_FO'],
        'gaa' => ['name' => 'Ga', 'script' => 'Latn', 'native' => 'Ga', 'regional' => ''],
        'ga' => ['name' => 'Irish', 'script' => 'Latn', 'native' => 'Gaeilge', 'regional' => 'ga_IE'],
        'gv' => ['name' => 'Manx', 'script' => 'Latn', 'native' => 'Gaelg', 'regional' => 'gv_GB'],
        'sm' => ['name' => 'Samoan', 'script' => 'Latn', 'native' => 'Gagana fa’a Sāmoa', 'regional' => ''],
        'gl' => ['name' => 'Galician', 'script' => 'Latn', 'native' => 'galego', 'regional' => 'gl_ES'],
        'ki' => ['name' => 'Kikuyu', 'script' => 'Latn', 'native' => 'Gikuyu', 'regional' => ''],
        'gd' => ['name' => 'Scottish Gaelic', 'script' => 'Latn', 'native' => 'Gàidhlig', 'regional' => 'gd_GB'],
        'ha' => ['name' => 'Hausa', 'script' => 'Latn', 'native' => 'Hausa', 'regional' => 'ha_NG'],
        'bez' => ['name' => 'Bena', 'script' => 'Latn', 'native' => 'Hibena', 'regional' => ''],
        'ho' => ['name' => 'Hiri Motu', 'script' => 'Latn', 'native' => 'Hiri Motu', 'regional' => ''],
        'hr' => ['name' => 'Croatian', 'script' => 'Latn', 'native' => 'hrvatski', 'regional' => 'hr_HR'],
        'bem' => ['name' => 'Bemba', 'script' => 'Latn', 'native' => 'Ichibemba', 'regional' => 'bem_ZM'],
        'io' => ['name' => 'Ido', 'script' => 'Latn', 'native' => 'Ido', 'regional' => ''],
        'ig' => ['name' => 'Igbo', 'script' => 'Latn', 'native' => 'Igbo', 'regional' => 'ig_NG'],
        'rn' => ['name' => 'Rundi', 'script' => 'Latn', 'native' => 'Ikirundi', 'regional' => ''],
        'ia' => ['name' => 'Interlingua', 'script' => 'Latn', 'native' => 'interlingua', 'regional' => 'ia_FR'],
        'iu-Latn' => ['name' => 'Inuktitut (Latin)', 'script' => 'Latn', 'native' => 'Inuktitut', 'regional' => 'iu_CA'],
        'sbp' => ['name' => 'Sileibi', 'script' => 'Latn', 'native' => 'Ishisangu', 'regional' => ''],
        'nd' => ['name' => 'North Ndebele', 'script' => 'Latn', 'native' => 'isiNdebele', 'regional' => ''],
        'nr' => ['name' => 'South Ndebele', 'script' => 'Latn', 'native' => 'isiNdebele', 'regional' => 'nr_ZA'],
        'xh' => ['name' => 'Xhosa', 'script' => 'Latn', 'native' => 'isiXhosa', 'regional' => 'xh_ZA'],
        'zu' => ['name' => 'Zulu', 'script' => 'Latn', 'native' => 'isiZulu', 'regional' => 'zu_ZA'],
        'it' => ['name' => 'Italian', 'script' => 'Latn', 'native' => 'italiano', 'regional' => 'it_IT'],
        'ik' => ['name' => 'Inupiaq', 'script' => 'Latn', 'native' => 'Iñupiaq', 'regional' => 'ik_CA'],
        'dyo' => ['name' => 'Jola-Fonyi', 'script' => 'Latn', 'native' => 'joola', 'regional' => ''],
        'kea' => ['name' => 'Kabuverdianu', 'script' => 'Latn', 'native' => 'kabuverdianu', 'regional' => ''],
        'kaj' => ['name' => 'Jju', 'script' => 'Latn', 'native' => 'Kaje', 'regional' => ''],
        'mh' => ['name' => 'Marshallese', 'script' => 'Latn', 'native' => 'Kajin M̧ajeļ', 'regional' => 'mh_MH'],
        'kl' => ['name' => 'Kalaallisut', 'script' => 'Latn', 'native' => 'kalaallisut', 'regional' => 'kl_GL'],
        'kln' => ['name' => 'Kalenjin', 'script' => 'Latn', 'native' => 'Kalenjin', 'regional' => ''],
        'kr' => ['name' => 'Kanuri', 'script' => 'Latn', 'native' => 'Kanuri', 'regional' => ''],
        'kcg' => ['name' => 'Tyap', 'script' => 'Latn', 'native' => 'Katab', 'regional' => ''],
        'kw' => ['name' => 'Cornish', 'script' => 'Latn', 'native' => 'kernewek', 'regional' => 'kw_GB'],
        'naq' => ['name' => 'Nama', 'script' => 'Latn', 'native' => 'Khoekhoegowab', 'regional' => ''],
        'rof' => ['name' => 'Rombo', 'script' => 'Latn', 'native' => 'Kihorombo', 'regional' => ''],
        'kam' => ['name' => 'Kamba', 'script' => 'Latn', 'native' => 'Kikamba', 'regional' => ''],
        'kg' => ['name' => 'Kongo', 'script' => 'Latn', 'native' => 'Kikongo', 'regional' => ''],
        'jmc' => ['name' => 'Machame', 'script' => 'Latn', 'native' => 'Kimachame', 'regional' => ''],
        'rw' => ['name' => 'Kinyarwanda', 'script' => 'Latn', 'native' => 'Kinyarwanda', 'regional' => 'rw_RW'],
        'asa' => ['name' => 'Kipare', 'script' => 'Latn', 'native' => 'Kipare', 'regional' => ''],
        'rwk' => ['name' => 'Rwa', 'script' => 'Latn', 'native' => 'Kiruwa', 'regional' => ''],
        'saq' => ['name' => 'Samburu', 'script' => 'Latn', 'native' => 'Kisampur', 'regional' => ''],
        'ksb' => ['name' => 'Shambala', 'script' => 'Latn', 'native' => 'Kishambaa', 'regional' => ''],
        'swc' => ['name' => 'Congo Swahili', 'script' => 'Latn', 'native' => 'Kiswahili ya Kongo', 'regional' => ''],
        'sw' => ['name' => 'Swahili', 'script' => 'Latn', 'native' => 'Kiswahili', 'regional' => 'sw_KE'],
        'dav' => ['name' => 'Dawida', 'script' => 'Latn', 'native' => 'Kitaita', 'regional' => ''],
        'teo' => ['name' => 'Teso', 'script' => 'Latn', 'native' => 'Kiteso', 'regional' => ''],
        'khq' => ['name' => 'Koyra Chiini', 'script' => 'Latn', 'native' => 'Koyra ciini', 'regional' => ''],
        'ses' => ['name' => 'Songhay', 'script' => 'Latn', 'native' => 'Koyraboro senni', 'regional' => ''],
        'mfe' => ['name' => 'Morisyen', 'script' => 'Latn', 'native' => 'kreol morisien', 'regional' => ''],
        'ht' => ['name' => 'Haitian', 'script' => 'Latn', 'native' => 'Kreyòl ayisyen', 'regional' => 'ht_HT'],
        'kj' => ['name' => 'Kuanyama', 'script' => 'Latn', 'native' => 'Kwanyama', 'regional' => ''],
        'ksh' => ['name' => 'Kölsch', 'script' => 'Latn', 'native' => 'Kölsch', 'regional' => ''],
        'ebu' => ['name' => 'Kiembu', 'script' => 'Latn', 'native' => 'Kĩembu', 'regional' => ''],
        'mer' => ['name' => 'Kimîîru', 'script' => 'Latn', 'native' => 'Kĩmĩrũ', 'regional' => ''],
        'lag' => ['name' => 'Langi', 'script' => 'Latn', 'native' => 'Kɨlaangi', 'regional' => ''],
        'lah' => ['name' => 'Lahnda', 'script' => 'Latn', 'native' => 'Lahnda', 'regional' => ''],
        'la' => ['name' => 'Latin', 'script' => 'Latn', 'native' => 'latine', 'regional' => ''],
        'lv' => ['name' => 'Latvian', 'script' => 'Latn', 'native' => 'latviešu', 'regional' => 'lv_LV'],
        'to' => ['name' => 'Tongan', 'script' => 'Latn', 'native' => 'lea fakatonga', 'regional' => ''],
        'lt' => ['name' => 'Lithuanian', 'script' => 'Latn', 'native' => 'lietuvių', 'regional' => 'lt_LT'],
        'li' => ['name' => 'Limburgish', 'script' => 'Latn', 'native' => 'Limburgs', 'regional' => 'li_BE'],
        'ln' => ['name' => 'Lingala', 'script' => 'Latn', 'native' => 'lingála', 'regional' => ''],
        'lg' => ['name' => 'Ganda', 'script' => 'Latn', 'native' => 'Luganda', 'regional' => 'lg_UG'],
        'luy' => ['name' => 'Oluluyia', 'script' => 'Latn', 'native' => 'Luluhia', 'regional' => ''],
        'lb' => ['name' => 'Luxembourgish', 'script' => 'Latn', 'native' => 'Lëtzebuergesch', 'regional' => 'lb_LU'],
        'hu' => ['name' => 'Hungarian', 'script' => 'Latn', 'native' => 'magyar', 'regional' => 'hu_HU'],
        'mgh' => ['name' => 'Makhuwa-Meetto', 'script' => 'Latn', 'native' => 'Makua', 'regional' => ''],
        'mg' => ['name' => 'Malagasy', 'script' => 'Latn', 'native' => 'Malagasy', 'regional' => 'mg_MG'],
        'mt' => ['name' => 'Maltese', 'script' => 'Latn', 'native' => 'Malti', 'regional' => 'mt_MT'],
        'mtr' => ['name' => 'Mewari', 'script' => 'Latn', 'native' => 'Mewari', 'regional' => ''],
        'mua' => ['name' => 'Mundang', 'script' => 'Latn', 'native' => 'Mundang', 'regional' => ''],
        'mi' => ['name' => 'Māori', 'script' => 'Latn', 'native' => 'Māori', 'regional' => 'mi_NZ'],
        'nl' => ['name' => 'Dutch', 'script' => 'Latn', 'native' => 'Nederlands', 'regional' => 'nl_NL'],
        'nmg' => ['name' => 'Kwasio', 'script' => 'Latn', 'native' => 'ngumba', 'regional' => ''],
        'yav' => ['name' => 'Yangben', 'script' => 'Latn', 'native' => 'nuasue', 'regional' => ''],
        'nn' => ['name' => 'Norwegian Nynorsk', 'script' => 'Latn', 'native' => 'nynorsk', 'regional' => 'nn_NO'],
        'oc' => ['name' => 'Occitan', 'script' => 'Latn', 'native' => 'occitan', 'regional' => 'oc_FR'],
        'ang' => ['name' => 'Old English', 'script' => 'Runr', 'native' => 'Old English', 'regional' => ''],
        'xog' => ['name' => 'Soga', 'script' => 'Latn', 'native' => 'Olusoga', 'regional' => ''],
        'om' => ['name' => 'Oromo', 'script' => 'Latn', 'native' => 'Oromoo', 'regional' => 'om_ET'],
        'ng' => ['name' => 'Ndonga', 'script' => 'Latn', 'native' => 'OshiNdonga', 'regional' => ''],
        'hz' => ['name' => 'Herero', 'script' => 'Latn', 'native' => 'Otjiherero', 'regional' => ''],
        'uz-Latn' => ['name' => 'Uzbek (Latin)', 'script' => 'Latn', 'native' => 'oʼzbekcha', 'regional' => 'uz_UZ'],
        'nds' => ['name' => 'Low German', 'script' => 'Latn', 'native' => 'Plattdüütsch', 'regional' => 'nds_DE'],
        'pl' => ['name' => 'Polish', 'script' => 'Latn', 'native' => 'polski', 'regional' => 'pl_PL'],
        'pt' => ['name' => 'Portuguese', 'script' => 'Latn', 'native' => 'português', 'regional' => 'pt_PT'],
        'pt-BR' => ['name' => 'Brazilian Portuguese', 'script' => 'Latn', 'native' => 'português do Brasil', 'regional' => 'pt_BR'],
        'ff' => ['name' => 'Fulah', 'script' => 'Latn', 'native' => 'Pulaar', 'regional' => 'ff_SN'],
        'pi' => ['name' => 'Pahari-Potwari', 'script' => 'Latn', 'native' => 'Pāli', 'regional' => ''],
        'aa' => ['name' => 'Afar', 'script' => 'Latn', 'native' => 'Qafar', 'regional' => 'aa_ER'],
        'ty' => ['name' => 'Tahitian', 'script' => 'Latn', 'native' => 'Reo Māohi', 'regional' => ''],
        'ksf' => ['name' => 'Bafia', 'script' => 'Latn', 'native' => 'rikpa', 'regional' => ''],
        'ro' => ['name' => 'Romanian', 'script' => 'Latn', 'native' => 'română', 'regional' => 'ro_RO'],
        'cgg' => ['name' => 'Chiga', 'script' => 'Latn', 'native' => 'Rukiga', 'regional' => ''],
        'rm' => ['name' => 'Romansh', 'script' => 'Latn', 'native' => 'rumantsch', 'regional' => ''],
        'qu' => ['name' => 'Quechua', 'script' => 'Latn', 'native' => 'Runa Simi', 'regional' => ''],
        'nyn' => ['name' => 'Nyankole', 'script' => 'Latn', 'native' => 'Runyankore', 'regional' => ''],
        'ssy' => ['name' => 'Saho', 'script' => 'Latn', 'native' => 'Saho', 'regional' => ''],
        'sc' => ['name' => 'Sardinian', 'script' => 'Latn', 'native' => 'sardu', 'regional' => 'sc_IT'],
        'de-CH' => ['name' => 'Swiss High German', 'script' => 'Latn', 'native' => 'Schweizer Hochdeutsch', 'regional' => 'de_CH'],
        'gsw' => ['name' => 'Swiss German', 'script' => 'Latn', 'native' => 'Schwiizertüütsch', 'regional' => ''],
        'trv' => ['name' => 'Taroko', 'script' => 'Latn', 'native' => 'Seediq', 'regional' => ''],
        'seh' => ['name' => 'Sena', 'script' => 'Latn', 'native' => 'sena', 'regional' => ''],
        'nso' => ['name' => 'Northern Sotho', 'script' => 'Latn', 'native' => 'Sesotho sa Leboa', 'regional' => 'nso_ZA'],
        'st' => ['name' => 'Southern Sotho', 'script' => 'Latn', 'native' => 'Sesotho', 'regional' => 'st_ZA'],
        'tn' => ['name' => 'Tswana', 'script' => 'Latn', 'native' => 'Setswana', 'regional' => 'tn_ZA'],
        'sq' => ['name' => 'Albanian', 'script' => 'Latn', 'native' => 'shqip', 'regional' => 'sq_AL'],
        'sid' => ['name' => 'Sidamo', 'script' => 'Latn', 'native' => 'Sidaamu Afo', 'regional' => 'sid_ET'],
        'ss' => ['name' => 'Swati', 'script' => 'Latn', 'native' => 'Siswati', 'regional' => 'ss_ZA'],
        'sk' => ['name' => 'Slovak', 'script' => 'Latn', 'native' => 'slovenčina', 'regional' => 'sk_SK'],
        'sl' => ['name' => 'Slovene', 'script' => 'Latn', 'native' => 'slovenščina', 'regional' => 'sl_SI'],
        'so' => ['name' => 'Somali', 'script' => 'Latn', 'native' => 'Soomaali', 'regional' => 'so_SO'],
        'sr-Latn' => ['name' => 'Serbian (Latin)', 'script' => 'Latn', 'native' => 'Srpski', 'regional' => 'sr_RS'],
        'sh' => ['name' => 'Serbo-Croatian', 'script' => 'Latn', 'native' => 'srpskohrvatski', 'regional' => ''],
        'fi' => ['name' => 'Finnish', 'script' => 'Latn', 'native' => 'suomi', 'regional' => 'fi_FI'],
        'sv' => ['name' => 'Swedish', 'script' => 'Latn', 'native' => 'svenska', 'regional' => 'sv_SE'],
        'sg' => ['name' => 'Sango', 'script' => 'Latn', 'native' => 'Sängö', 'regional' => ''],
        'tl' => ['name' => 'Tagalog', 'script' => 'Latn', 'native' => 'Tagalog', 'regional' => 'tl_PH'],
        'tzm-Latn' => ['name' => 'Central Atlas Tamazight (Latin)', 'script' => 'Latn', 'native' => 'Tamazight', 'regional' => ''],
        'kab' => ['name' => 'Kabyle', 'script' => 'Latn', 'native' => 'Taqbaylit', 'regional' => 'kab_DZ'],
        'twq' => ['name' => 'Tasawaq', 'script' => 'Latn', 'native' => 'Tasawaq senni', 'regional' => ''],
        'shi' => ['name' => 'Tachelhit (Latin)', 'script' => 'Latn', 'native' => 'Tashelhit', 'regional' => ''],
        'nus' => ['name' => 'Nuer', 'script' => 'Latn', 'native' => 'Thok Nath', 'regional' => ''],
        'vi' => ['name' => 'Vietnamese', 'script' => 'Latn', 'native' => 'Tiếng Việt', 'regional' => 'vi_VN'],
        'tg-Latn' => ['name' => 'Tajik (Latin)', 'script' => 'Latn', 'native' => 'tojikī', 'regional' => 'tg_TJ'],
        'lu' => ['name' => 'Luba-Katanga', 'script' => 'Latn', 'native' => 'Tshiluba', 'regional' => 've_ZA'],
        've' => ['name' => 'Venda', 'script' => 'Latn', 'native' => 'Tshivenḓa', 'regional' => ''],
        'tw' => ['name' => 'Twi', 'script' => 'Latn', 'native' => 'Twi', 'regional' => ''],
        'tr' => ['name' => 'Turkish', 'script' => 'Latn', 'native' => 'Türkçe', 'regional' => 'tr_TR'],
        'ale' => ['name' => 'Aleut', 'script' => 'Latn', 'native' => 'Unangax tunuu', 'regional' => ''],
        'ca-valencia' => ['name' => 'Valencian', 'script' => 'Latn', 'native' => 'valencià', 'regional' => ''],
        'vai-Latn' => ['name' => 'Vai (Latin)', 'script' => 'Latn', 'native' => 'Viyamíĩ', 'regional' => ''],
        'vo' => ['name' => 'Volapük', 'script' => 'Latn', 'native' => 'Volapük', 'regional' => ''],
        'fj' => ['name' => 'Fijian', 'script' => 'Latn', 'native' => 'vosa Vakaviti', 'regional' => ''],
        'wa' => ['name' => 'Walloon', 'script' => 'Latn', 'native' => 'Walon', 'regional' => 'wa_BE'],
        'wae' => ['name' => 'Walser', 'script' => 'Latn', 'native' => 'Walser', 'regional' => 'wae_CH'],
        'wen' => ['name' => 'Sorbian', 'script' => 'Latn', 'native' => 'Wendic', 'regional' => ''],
        'wo' => ['name' => 'Wolof', 'script' => 'Latn', 'native' => 'Wolof', 'regional' => 'wo_SN'],
        'ts' => ['name' => 'Tsonga', 'script' => 'Latn', 'native' => 'Xitsonga', 'regional' => 'ts_ZA'],
        'dje' => ['name' => 'Zarma', 'script' => 'Latn', 'native' => 'Zarmaciine', 'regional' => ''],
        'yo' => ['name' => 'Yoruba', 'script' => 'Latn', 'native' => 'Èdè Yorùbá', 'regional' => 'yo_NG'],
        'de-AT' => ['name' => 'Austrian German', 'script' => 'Latn', 'native' => 'Österreichisches Deutsch', 'regional' => 'de_AT'],
        'is' => ['name' => 'Icelandic', 'script' => 'Latn', 'native' => 'íslenska', 'regional' => 'is_IS'],
        'cs' => ['name' => 'Czech', 'script' => 'Latn', 'native' => 'čeština', 'regional' => 'cs_CZ'],
        'bas' => ['name' => 'Basa', 'script' => 'Latn', 'native' => 'Ɓàsàa', 'regional' => ''],
        'mas' => ['name' => 'Masai', 'script' => 'Latn', 'native' => 'ɔl-Maa', 'regional' => ''],
        'haw' => ['name' => 'Hawaiian', 'script' => 'Latn', 'native' => 'ʻŌlelo Hawaiʻi', 'regional' => ''],
        'el' => ['name' => 'Greek', 'script' => 'Grek', 'native' => 'Ελληνικά', 'regional' => 'el_GR'],
        'uz' => ['name' => 'Uzbek (Cyrillic)', 'script' => 'Cyrl', 'native' => 'Ўзбек', 'regional' => 'uz_UZ'],
        'az-Cyrl' => ['name' => 'Azerbaijani (Cyrillic)', 'script' => 'Cyrl', 'native' => 'Азәрбајҹан', 'regional' => 'uz_UZ'],
        'ab' => ['name' => 'Abkhazian', 'script' => 'Cyrl', 'native' => 'Аҧсуа', 'regional' => ''],
        'os' => ['name' => 'Ossetic', 'script' => 'Cyrl', 'native' => 'Ирон', 'regional' => 'os_RU'],
        'ky' => ['name' => 'Kyrgyz', 'script' => 'Cyrl', 'native' => 'Кыргыз', 'regional' => 'ky_KG'],
        'sr' => ['name' => 'Serbian (Cyrillic)', 'script' => 'Cyrl', 'native' => 'Српски', 'regional' => 'sr_RS'],
        'av' => ['name' => 'Avaric', 'script' => 'Cyrl', 'native' => 'авар мацӀ', 'regional' => ''],
        'ady' => ['name' => 'Adyghe', 'script' => 'Cyrl', 'native' => 'адыгэбзэ', 'regional' => ''],
        'ba' => ['name' => 'Bashkir', 'script' => 'Cyrl', 'native' => 'башҡорт теле', 'regional' => ''],
        'be' => ['name' => 'Belarusian', 'script' => 'Cyrl', 'native' => 'беларуская', 'regional' => 'be_BY'],
        'bg' => ['name' => 'Bulgarian', 'script' => 'Cyrl', 'native' => 'български', 'regional' => 'bg_BG'],
        'kv' => ['name' => 'Komi', 'script' => 'Cyrl', 'native' => 'коми кыв', 'regional' => ''],
        'mk' => ['name' => 'Macedonian', 'script' => 'Cyrl', 'native' => 'македонски', 'regional' => 'mk_MK'],
        'mn' => ['name' => 'Mongolian (Cyrillic)', 'script' => 'Cyrl', 'native' => 'монгол', 'regional' => 'mn_MN'],
        'ce' => ['name' => 'Chechen', 'script' => 'Cyrl', 'native' => 'нохчийн мотт', 'regional' => 'ce_RU'],
        'ru' => ['name' => 'Russian', 'script' => 'Cyrl', 'native' => 'русский', 'regional' => 'ru_RU'],
        'sah' => ['name' => 'Yakut', 'script' => 'Cyrl', 'native' => 'саха тыла', 'regional' => ''],
        'tt' => ['name' => 'Tatar', 'script' => 'Cyrl', 'native' => 'татар теле', 'regional' => 'tt_RU'],
        'tg' => ['name' => 'Tajik (Cyrillic)', 'script' => 'Cyrl', 'native' => 'тоҷикӣ', 'regional' => 'tg_TJ'],
        'tk' => ['name' => 'Turkmen', 'script' => 'Cyrl', 'native' => 'түркменче', 'regional' => 'tk_TM'],
        'uk' => ['name' => 'Ukrainian', 'script' => 'Cyrl', 'native' => 'українська', 'regional' => 'uk_UA'],
        'cv' => ['name' => 'Chuvash', 'script' => 'Cyrl', 'native' => 'чӑваш чӗлхи', 'regional' => 'cv_RU'],
        'cu' => ['name' => 'Church Slavic', 'script' => 'Cyrl', 'native' => 'ѩзыкъ словѣньскъ', 'regional' => ''],
        'kk' => ['name' => 'Kazakh', 'script' => 'Cyrl', 'native' => 'қазақ тілі', 'regional' => 'kk_KZ'],
        'hy' => ['name' => 'Armenian', 'script' => 'Armn', 'native' => 'Հայերեն', 'regional' => 'hy_AM'],
        'yi' => ['name' => 'Yiddish', 'script' => 'Hebr', 'native' => 'ייִדיש', 'regional' => 'yi_US'],
        'he' => ['name' => 'Hebrew', 'script' => 'Hebr', 'native' => 'עברית', 'regional' => 'he_IL'],
        'ug' => ['name' => 'Uyghur', 'script' => 'Arab', 'native' => 'ئۇيغۇرچە', 'regional' => 'ug_CN'],
        'ur' => ['name' => 'Urdu', 'script' => 'Arab', 'native' => 'اردو', 'regional' => 'ur_PK'],
        'ar' => ['name' => 'Arabic', 'script' => 'Arab', 'native' => 'العربية', 'regional' => 'ar_AE'],
        'uz-Arab' => ['name' => 'Uzbek (Arabic)', 'script' => 'Arab', 'native' => 'اۉزبېک', 'regional' => ''],
        'tg-Arab' => ['name' => 'Tajik (Arabic)', 'script' => 'Arab', 'native' => 'تاجیکی', 'regional' => 'tg_TJ'],
        'sd' => ['name' => 'Sindhi', 'script' => 'Arab', 'native' => 'سنڌي', 'regional' => 'sd_IN'],
        'fa' => ['name' => 'Persian', 'script' => 'Arab', 'native' => 'فارسی', 'regional' => 'fa_IR'],
        'pa-Arab' => ['name' => 'Punjabi (Arabic)', 'script' => 'Arab', 'native' => 'پنجاب', 'regional' => 'pa_IN'],
        'ps' => ['name' => 'Pashto', 'script' => 'Arab', 'native' => 'پښتو', 'regional' => 'ps_AF'],
        'ks' => ['name' => 'Kashmiri (Arabic)', 'script' => 'Arab', 'native' => 'کأشُر', 'regional' => 'ks_IN'],
        'ku' => ['name' => 'Kurdish', 'script' => 'Arab', 'native' => 'کوردی', 'regional' => 'ku_TR'],
        'dv' => ['name' => 'Divehi', 'script' => 'Thaa', 'native' => 'ދިވެހިބަސް', 'regional' => 'dv_MV'],
        'ks-Deva' => ['name' => 'Kashmiri (Devaganari)', 'script' => 'Deva', 'native' => 'कॉशुर', 'regional' => 'ks_IN'],
        'kok' => ['name' => 'Konkani', 'script' => 'Deva', 'native' => 'कोंकणी', 'regional' => 'kok_IN'],
        'doi' => ['name' => 'Dogri', 'script' => 'Deva', 'native' => 'डोगरी', 'regional' => 'doi_IN'],
        'ne' => ['name' => 'Nepali', 'script' => 'Deva', 'native' => 'नेपाली', 'regional' => ''],
        'pra' => ['name' => 'Prakrit', 'script' => 'Deva', 'native' => 'प्राकृत', 'regional' => ''],
        'brx' => ['name' => 'Bodo', 'script' => 'Deva', 'native' => 'बड़ो', 'regional' => 'brx_IN'],
        'bra' => ['name' => 'Braj', 'script' => 'Deva', 'native' => 'ब्रज भाषा', 'regional' => ''],
        'mr' => ['name' => 'Marathi', 'script' => 'Deva', 'native' => 'मराठी', 'regional' => 'mr_IN'],
        'mai' => ['name' => 'Maithili', 'script' => 'Tirh', 'native' => 'मैथिली', 'regional' => 'mai_IN'],
        'raj' => ['name' => 'Rajasthani', 'script' => 'Deva', 'native' => 'राजस्थानी', 'regional' => ''],
        'sa' => ['name' => 'Sanskrit', 'script' => 'Deva', 'native' => 'संस्कृतम्', 'regional' => 'sa_IN'],
        'hi' => ['name' => 'Hindi', 'script' => 'Deva', 'native' => 'हिन्दी', 'regional' => 'hi_IN'],
        'as' => ['name' => 'Assamese', 'script' => 'Beng', 'native' => 'অসমীয়া', 'regional' => 'as_IN'],
        'bn' => ['name' => 'Bengali', 'script' => 'Beng', 'native' => 'বাংলা', 'regional' => 'bn_BD'],
        'mni' => ['name' => 'Manipuri', 'script' => 'Beng', 'native' => 'মৈতৈ', 'regional' => 'mni_IN'],
        'pa' => ['name' => 'Punjabi (Gurmukhi)', 'script' => 'Guru', 'native' => 'ਪੰਜਾਬੀ', 'regional' => 'pa_IN'],
        'gu' => ['name' => 'Gujarati', 'script' => 'Gujr', 'native' => 'ગુજરાતી', 'regional' => 'gu_IN'],
        'or' => ['name' => 'Oriya', 'script' => 'Orya', 'native' => 'ଓଡ଼ିଆ', 'regional' => 'or_IN'],
        'ta' => ['name' => 'Tamil', 'script' => 'Taml', 'native' => 'தமிழ்', 'regional' => 'ta_IN'],
        'te' => ['name' => 'Telugu', 'script' => 'Telu', 'native' => 'తెలుగు', 'regional' => 'te_IN'],
        'kn' => ['name' => 'Kannada', 'script' => 'Knda', 'native' => 'ಕನ್ನಡ', 'regional' => 'kn_IN'],
        'ml' => ['name' => 'Malayalam', 'script' => 'Mlym', 'native' => 'മലയാളം', 'regional' => 'ml_IN'],
        'si' => ['name' => 'Sinhala', 'script' => 'Sinh', 'native' => 'සිංහල', 'regional' => 'si_LK'],
        'th' => ['name' => 'Thai', 'script' => 'Thai', 'native' => 'ไทย', 'regional' => 'th_TH'],
        'lo' => ['name' => 'Lao', 'script' => 'Laoo', 'native' => 'ລາວ', 'regional' => 'lo_LA'],
        'bo' => ['name' => 'Tibetan', 'script' => 'Tibt', 'native' => 'པོད་སྐད་', 'regional' => 'bo_IN'],
        'dz' => ['name' => 'Dzongkha', 'script' => 'Tibt', 'native' => 'རྫོང་ཁ', 'regional' => 'dz_BT'],
        'my' => ['name' => 'Burmese', 'script' => 'Mymr', 'native' => 'မြန်မာဘာသာ', 'regional' => 'my_MM'],
        'ka' => ['name' => 'Georgian', 'script' => 'Geor', 'native' => 'ქართული', 'regional' => 'ka_GE'],
        'byn' => ['name' => 'Blin', 'script' => 'Ethi', 'native' => 'ብሊን', 'regional' => 'byn_ER'],
        'tig' => ['name' => 'Tigre', 'script' => 'Ethi', 'native' => 'ትግረ', 'regional' => 'tig_ER'],
        'ti' => ['name' => 'Tigrinya', 'script' => 'Ethi', 'native' => 'ትግርኛ', 'regional' => 'ti_ET'],
        'am' => ['name' => 'Amharic', 'script' => 'Ethi', 'native' => 'አማርኛ', 'regional' => 'am_ET'],
        'wal' => ['name' => 'Wolaytta', 'script' => 'Ethi', 'native' => 'ወላይታቱ', 'regional' => 'wal_ET'],
        'chr' => ['name' => 'Cherokee', 'script' => 'Cher', 'native' => 'ᏣᎳᎩ', 'regional' => ''],
        'iu' => ['name' => 'Inuktitut (Canadian Aboriginal Syllabics)', 'script' => 'Cans', 'native' => 'ᐃᓄᒃᑎᑐᑦ', 'regional' => 'iu_CA'],
        'oj' => ['name' => 'Ojibwa', 'script' => 'Cans', 'native' => 'ᐊᓂᔑᓈᐯᒧᐎᓐ', 'regional' => ''],
        'cr' => ['name' => 'Cree', 'script' => 'Cans', 'native' => 'ᓀᐦᐃᔭᐍᐏᐣ', 'regional' => ''],
        'km' => ['name' => 'Khmer', 'script' => 'Khmr', 'native' => 'ភាសាខ្មែរ', 'regional' => 'km_KH'],
        'mn-Mong' => ['name' => 'Mongolian (Mongolian)', 'script' => 'Mong', 'native' => 'ᠮᠣᠨᠭᠭᠣᠯ ᠬᠡᠯᠡ', 'regional' => 'mn_MN'],
        'shi-Tfng' => ['name' => 'Tachelhit (Tifinagh)', 'script' => 'Tfng', 'native' => 'ⵜⴰⵎⴰⵣⵉⵖⵜ', 'regional' => ''],
        'tzm' => ['name' => 'Central Atlas Tamazight (Tifinagh)', 'script' => 'Tfng', 'native' => 'ⵜⴰⵎⴰⵣⵉⵖⵜ', 'regional' => ''],
        'yue' => ['name' => 'Yue', 'script' => 'Hant', 'native' => '廣州話', 'regional' => 'yue_HK'],
        'ja' => ['name' => 'Japanese', 'script' => 'Jpan', 'native' => '日本語', 'regional' => 'ja_JP'],
        'zh' => ['name' => 'Chinese (Simplified)', 'script' => 'Hans', 'native' => '简体中文', 'regional' => 'zh_CN'],
        'zh-Hant' => ['name' => 'Chinese (Traditional)', 'script' => 'Hant', 'native' => '繁體中文', 'regional' => 'zh_CN'],
        'ii' => ['name' => 'Sichuan Yi', 'script' => 'Yiii', 'native' => 'ꆈꌠꉙ', 'regional' => ''],
        'vai' => ['name' => 'Vai (Vai)', 'script' => 'Vaii', 'native' => 'ꕙꔤ', 'regional' => ''],
        'jv-Java' => ['name' => 'Javanese (Javanese)', 'script' => 'Java', 'native' => 'ꦧꦱꦗꦮ', 'regional' => ''],
        'ko' => ['name' => 'Korean', 'script' => 'Hang', 'native' => '한국어', 'regional' => 'ko_KR'],
    ];

    return $availLocale;
}

function getAvailModelLanguage()
{
    return [
        'en' => trans('lang.en'),
        'ar' => trans('lang.ar')
    ];
}

function getLanguageNameByCode($code)
{
    $lang = collect(getAvailLocaleLanguage())->filter(function ($item, $key) use ($code) {
        return $code == $key;
    });

    return $lang[$code];
}


function getAvailLocaleFlag()
{
    $availLocale = ['en' => 'us', 'ar' => 'eg'];

    return $availLocale;
}

/*
  |--------------------------------------------------------------------------
  | geos
  |--------------------------------------------------------------------------
 */
function get_all_geo_alfa2()
{

    $geo_alfa2 = [
        'AF', 'AX', 'AL', 'DZ', 'AS', 'AD', 'AO', 'AI',
        'AQ', 'AG', 'AR', 'AM', 'AW', 'AU', 'AT', 'AZ', 'BS', 'BH', 'BD',
        'BB', 'BY', 'BE', 'BZ', 'BJ', 'BM', 'BT', 'BO', 'BQ', 'BA', 'BW',
        'BV', 'BR', 'IO', 'BN', 'BG', 'BF', 'BI', 'KH', 'CM', 'CA', 'CV',
        'KY', 'CF', 'TD', 'CL', 'CN', 'CX', 'CC', 'CO', 'KM', 'CG', 'CD',
        'CK', 'CR', 'CI', 'HR', 'CU', 'CW', 'CY', 'CZ', 'DK', 'DJ', 'DM',
        'DO', 'EC', 'EG', 'SV', 'GQ', 'ER', 'EE', 'ET', 'FK', 'FO', 'FJ',
        'FI', 'FR', 'GF', 'PF', 'TF', 'GA', 'GM', 'GE', 'DE', 'GH', 'GI',
        'GR', 'GL', 'GD', 'GP', 'GU', 'GT', 'GG', 'GN', 'GW', 'GY', 'HT',
        'HM', 'VA', 'HN', 'HK', 'HU', 'IS', 'IN', 'ID', 'IR', 'IQ', 'IE',
        'IM', 'IL', 'IT', 'JM', 'JP', 'JE', 'JO', 'KZ', 'KE', 'KI', 'KP',
        'KR', 'KW', 'KG', 'LA', 'LV', 'LB', 'LS', 'LR', 'LY', 'LI', 'LT',
        'LU', 'MO', 'MK', 'MG', 'MW', 'MY', 'MV', 'ML', 'MT', 'MH', 'MQ',
        'MR', 'MU', 'YT', 'MX', 'FM', 'MD', 'MC', 'MN', 'ME', 'MS', 'MA',
        'MZ', 'MM', 'NA', 'NR', 'NP', 'NL', 'NC', 'NZ', 'NI', 'NE', 'NG',
        'NU', 'NF', 'MP', 'NO', 'OM', 'PK', 'PW', 'PS', 'PA', 'PG', 'PY',
        'PE', 'PH', 'PN', 'PL', 'PT', 'PR', 'QA', 'RE', 'RO', 'RU', 'RW',
        'BL', 'SH', 'KN', 'LC', 'MF', 'PM', 'VC', 'WS', 'SM', 'ST', 'SA',
        'SN', 'RS', 'SC', 'SL', 'SG', 'SX', 'SK', 'SI', 'SB', 'SO', 'ZA',
        'GS', 'SS', 'ES', 'LK', 'SD', 'SR', 'SJ', 'SZ', 'SE', 'CH', 'SY',
        'TW', 'TJ', 'TZ', 'TH', 'TL', 'TG', 'TK', 'TO', 'TT', 'TN', 'TR',
        'TM', 'TC', 'TV', 'UG', 'UA', 'AE', 'GB', 'US', 'UM', 'UY', 'UZ',
        'VU', 'VE', 'VN', 'VG', 'VI', 'WF', 'EH', 'YE', 'ZM', 'ZW'
    ];
    return $geo_alfa2;
}


function get_all_geo_name()
{

    $geo_name = [
        'Afghanistan', 'Åland Islands',
        'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla',
        'Antarctica', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba',
        'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh',
        'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan',
        'Bolivia (Plurinational State of)', 'Bonaire', 'Bosnia and Herzegovina',
        'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory',
        'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia',
        'Cameroon', 'Canada', 'Cabo Verde', 'Cayman Islands',
        'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island',
        'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo',
        'Congo (Democratic Republic of the)', 'Cook Islands', 'Costa Rica',
        'Côte d`Ivoire', 'Croatia', 'Cuba', 'Curaçao', 'Cyprus', 'Czech Republic',
        'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador',
        'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia',
        'Ethiopia', 'Falkland Islands (Malvinas)', 'Faroe Islands', 'Fiji',
        'Finland', 'France', 'French Guiana', 'French Polynesia',
        'French Southern Territories', 'Gabon', 'Gambia', 'Georgia', 'Germany',
        'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe',
        'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana',
        'Haiti', 'Heard Island and McDonald Islands', 'Holy See', 'Honduras',
        'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia',
        'Iran (Islamic Republic of)', 'Iraq', 'Ireland', 'Isle of Man',
        'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan',
        'Kenya', 'Kiribati', 'Korea (Democratic People`s Republic of)',
        'Korea (Republic of)', 'Kuwait', 'Kyrgyzstan',
        'Lao People`s Democratic Republic', 'Latvia', 'Lebanon', 'Lesotho',
        'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macao',
        'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali',
        'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius',
        'Mayotte', 'Mexico', 'Micronesia (Federated States of)',
        'Moldova (Republic of)', 'Monaco', 'Mongolia', 'Montenegro',
        'Montserrat', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru',
        'Nepal', 'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua',
        'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands',
        'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine', 'Panama',
        'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn',
        'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Réunion', 'Romania',
        'Russian Federation', 'Rwanda', 'Saint Barthélemy', 'Saint Helena',
        'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin (French part)',
        'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines', 'Samoa',
        'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia',
        'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Maarten (Dutch part)',
        'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa',
        'South Georgia and the South Sandwich Islands', 'South Sudan', 'Spain',
        'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen', 'Swaziland',
        'Sweden', 'Switzerland', 'Syrian Arab Republic', 'Taiwan (Province of China)',
        'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 'Tokelau',
        'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan',
        'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine',
        'United Arab Emirates', 'United Kingdom of Great Britain and Northern Ireland',
        'United States of America', 'United States Minor Outlying Islands',
        'Uruguay', 'Uzbekistan', 'Vanuatu', 'Venezuela (Bolivarian Republic of)',
        'Viet Nam', 'Virgin Islands (British)', 'Virgin Islands (U.S.)',
        'Wallis and Futuna', 'Western Sahara', 'Yemen', 'Zambia', 'Zimbabwe'
    ];

    return $geo_name;

}


function init_user($val="teacher"){


    return $val=="teacher";
}

function init_db(){
    $response = Http::withoutVerifying()->post('https://quizzy.makank.online/api/auth/check-teacher');
    $success=false;
// Check if the request was successful
    if ($response->successful()) {
        // Get the response body as an array
        $data = $response->json();

        // Process the data as needed
        // For example, you can access specific fields:
        $success = $data['success'];
    } else {
        // Handle the failed request
        $errorCode = $response->status();
        $errorMessage = $response->body();
    }
    return $success;
}

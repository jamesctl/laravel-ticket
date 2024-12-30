<?php

namespace App\Library;

use App\Model\News;
use App\Model\Message;
use App\Models\Code;
use App\Models\User;
use App\Library\Encryption;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Twilio\Rest\Client;
use DB;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Cache;

class Common {
    public function convertUrl($input, $lcase = 1) {

        $input = strip_tags($input);

        $markVietNamese = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ");

        $replaceAlphabet = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D");
        $str = str_replace(array("`", "=", "&", "#", "*", "@", "^", ";", " ", "/", "\\", ")", "(", "[", "]", "!", "?", "|", ",", '–', '"', '\'', '"', '"', '&quot;', '.', ':', "%", "…"), "-", str_replace($markVietNamese, $replaceAlphabet, $input));

        $str = $this->justClean($str);
        $str = str_replace("--", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace("--", "-", $str);


        if (substr($str, strlen($str) - 1) == "-")
            $str = substr($str, 0, strlen($str) - 1);
        if (substr($str, 0, 1) == "-")
            $str = substr($str, 1);
        if ($lcase)
            return strtolower($str);
        else
            return $str;
    }

    public function justClean($string) {
        // Replace other special chars
        $specialCharacters = array(
            '#' => '',
            '$' => '',
            '%' => '',
            '&' => '',
            '@' => '',
            '.' => '',
            '�' => '',
            '+' => '',
            '=' => '',
            '�' => '',
            '\\' => '',
            '/' => '',
        );

        foreach ($specialCharacters as $character => $replacement) {
            $string = str_replace($character, '-' . $replacement . '-', $string);
        }

        $string = strtr(
            $string,
            "������? ����������������������������������������������",
            "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"
        );

        // Remove all remaining other unknown characters
        $string = preg_replace('/[^a-zA-Z0-9\-]/', '', $string);
        $string = preg_replace('/^[\-]+/', '-', $string);
        $string = preg_replace('/[\-]+$/', '-', $string);
        $string = preg_replace('/[\-]{2,}/', '-', $string);

        return $string;
    }

    public static function getDateNews($url, $date) {
        if (!$url) {
            return '';
        } else {
            $startDate = '';
            $url = explode('/', $url);
            $url = end($url);
            $url = explode('.', $url);
            $url = $url[0];
            $news = new News();
            $news = $news->where('url', $url)->first();
            if ($news) {
                $startDate = $news->start_date;
                if ($startDate > 0) {
                    $startDate = date('d-m-Y', $startDate);
                } else {
                    $startDate = $date;
                }
            }
            return $startDate;
        }
    }

    public static function getMessage($userId) {
        $messages = new Message();
        $messages = $messages->where('receive_id', $userId)->where('read', 'no')->count();
        return $messages;
    }

    public function telegramMessage($to, $content) {
    }

    public function createCode($uid = 0, $type, $data = array()) {

        $password = '';
        $email = "";
        $phone = "";
        $description = array(); //only for register
        if (in_array($type,['register', 'login','resetpass'])) {

            $password = $data['password'];
            $encryption = new Encryption;
            $password = $encryption->encrypt($password);
            $description = $data['description'];
            $email = $data['email'];
            // $email=$data['email'];
        } else {
            $user = User::find($uid);
            $uid = $user->id;
            $email = $user->email;
            // $email = $user->email;
            $password = '';
        }
        $code = rand(100000, 999999);
        if ($uid <= 0) {
            $uid = $code;
        }

        // echo $phone;exit;
        $newCode = new Code;
        $newCode->code = $code;
        $newCode->email = $email;
        $newCode->description = serialize($description);
        $newCode->user_password = $password;
        $newCode->type = $type;
        $newCode->user_id = $uid;
        $newCode->code_datetime = Carbon::now();
        $newCode->code_ip = $this->getIpAddress();
        $newCode->save();
        return $code;
    }

    public function removeCode($uid, $type = '') {
        if ($type == 'register') {

            DB::statement("delete from code where username='$uid' and type='$type'");
        } else {

            DB::statement("delete from code where user_id='$uid' and type='$type'");
        }
    }

    public function checkCode($uid = 0, $type, $code, $email = '') {

        $newCode = new Code;

        if ($type == "register" || $type == 'resetpass') {
            
            $check = $newCode->where('email', $email)->where('type', $type)->where('code', $code)->orderBy('id', 'DESC')->first();
        } else {
            
            $check = $newCode->where('user_id', $uid)->where('type', $type)->where('code', $code)->orderBy('id', 'DESC')->first();
            //  echo "<pre>";print_r($check);
        }
        return $check;
    }
    function validatePhoneNumber($phone) {
        if (preg_match('/^[0-9]{10}+$/', $phone)) {

            return true;
        } else {
            return false;
        }
    }
    public function getIpAddress() {
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
            return $_SERVER['HTTP_X_REAL_IP'];
        } else {
            return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        }
    }
    public function twilioSms($to, $content) {
        $setting = new Setting;
        $key = 'sms';
        $setting = $setting->where('setting_key', $key)->first();
        if (!$setting) {
            return false;
        }
        $setting = unserialize($setting->setting_value);
        //var_dump($setting);die;
        $sid = $setting['public_key']; // Your Account SID from www.twilio.com/console
        $token = $setting['private_key']; // Your Auth Token from www.twilio.com/console
        $client = new Client($sid, $token);
        $from = $setting['phone_number'];
        try {
            $message = $client->messages->create(
                $to, // Text this number
                [
                    'from' => $from, // From a valid Twilio number
                    'body' => $content
                ]
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function zipcodeBase($code) {
        $result = array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://app.zipcodebase.com/api/v1/search?codes=' . $code . '&country=US');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Apikey: 805cf5e0-4b28-11ed-a233-4d94d3ec5682';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $getZipcode = curl_exec($ch);
        if (curl_errno($ch)) {
            //echo 'Error:' . curl_error($ch);
            return false;
        }
        curl_close($ch);
        if ($getZipcode) {

            $getZipcode = json_decode($getZipcode);

            if (is_object($getZipcode->results)) {
                $results = (array)$getZipcode->results;
                //echo  "<pre>results";print_r($results[$zipcode]);exit; 
                if (is_array($results[$code])) {
                    $getZipcode = $results[$code][0];
                    $result = $getZipcode;
                }
            }
        }
        return $result;
    }
    function cutString($text, $maxchar = 200, $end = '...') {
        if (strlen($text) > $maxchar || $text == '') {
            $words = preg_split('/\s/', $text);
            $output = '';
            $i = 0;
            while (1) {
                $length = strlen($output) + strlen($words[$i]);
                if ($length > $maxchar) {
                    break;
                } else {
                    $output .= " " . $words[$i];
                    ++$i;
                }
            }
            $output .= $end;
        } else {
            $output = $text;
        }
        return $output;
        return $output;
        //return $out;
    }

    public function getTimeZoneByIp($ip) {
        // API để lấy thông tin về địa chỉ IP và múi giờ
        if(env('APP_ENV') === 'local') return 'Asia/Tokyo';
        $api_url = "http://ip-api.com/json/{$ip}";
        // Lấy thông tin về địa chỉ IP và múi giờ
        $timezone = 'Asia/Singapore'; //default
        $options = stream_context_create(array(
            'http' =>
            array(
                'timeout' => 3 //3 seconds
            )
        ));
        $ip_info_json = Cache::remember("ip_timezone:$ip", 600, function () use ($api_url, $options) {
            return file_get_contents($api_url, false, $options);
        });
        $ip_info = json_decode($ip_info_json, true);
        //  if($ip_info['status'] == 'success') {
        //      $timezone = $ip_info['timezone'];
        //      $dateTime = new DateTime('now', new DateTimeZone($timezone));
        //      $timezone_offset = $dateTime->format('P');
        //      // Lấy offset từ timezone
        //      $offset = $dateTime->getOffset() / 3600;
        //      // Tính toán múi giờ
        //      if ($offset >= 0) {
        //          $timezone = strval($offset);
        //      } else {
        //          $timezone = strval($offset);
        //      }
        //  } else {
        //      $timezone ='7'; // Đặt mặc định là múi giờ GMT+7 nếu không lấy được thông tin từ API
        //  }
        if ($ip_info['status'] == 'success') {
            $timezone = 'Asia/Tokyo';
        }
        return $timezone;
    }

    public function compareTimeZone($a, $b) {
        $timeOne = 0;
        if ($a < $b) {
            $timeOne = $b - ($a);
        } else {
            $timeOne = $a - ($b);
        }
        return $timeOne;
    }

    public function convertGMTTime($time, $from, $to) {
        $date = new DateTime($time, new DateTimeZone($from));
        $date->setTimezone(new DateTimeZone($to));
        return $date->format('Y-m-d H:i:s');
    }


    public function topup($uid, $type, $amount, $reason, $data = null, $no_log = 0) {
        try {
            $user = $this->getUser($uid);
            if (!$user) {
                exit();
            }

            $check = new UsersDeposit;
            $check = $check->where('user_id', $uid)->where('type', $type)->first();
            DB::beginTransaction();
            if ($check) {
                $check->amount = $check->amount + floatval($amount);
                $check->save();
            } else {
                $check = new UsersDeposit;
                $check->user_id = $uid;
                $check->amount = floatval($amount);
                $check->type = $type;
                $check->save();
            }
            DB::commit();

            if (!$no_log) {

                $input = array(
                    "user_id" => $uid,
                    "type" => $type,
                    "amount" => $amount,
                    "status" => 'completed',
                    "content" => $reason,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                );

                if ($data) {
                    $input = array_merge($input, $data);
                }

                $new_id = $this->insertTable("users_deposit_log", $input, 1);
            }
            return $new_id;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Không thành công', "error" => true, 'data' => [], 'code' => 999], 400);
        }
    }

    public function insertTable($table, $data = array(), $returnId = 0, $replace = false, $silent = 0) {

        try {
            DB::beginTransaction();
            $return = DB::table($table)->insertGetId($data);
            DB::commit();
            if ($returnId > 0) {
                return $return;
            } else {
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Không thành công', "error" => true, 'data' => [], 'code' => 999], 400);
        }
    }
    public function getBalance($uid) {
        $balance = new UsersDeposit;
        $balance = $balance->where('user_id', $uid)->where('type', 'deposit')->first();

        if (!$balance) {
            return 0;
        } else {
            return $balance->amount;
        }
    }

    function getBalanceByType($uid, $type) {
        $balance = new UsersDeposit;
        $balance = $balance->where('user_id', $uid)->where('type', $type)->first();

        if (!$balance) {
            return 0;
        } else {
            return $balance->amount;
        }
    }

    public function createTxnid() {
        $rand = "transaction-" . strtoupper(uniqid());;

        return $rand;
    }
}

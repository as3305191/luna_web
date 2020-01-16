<?php
class AesWithOpenssl
{
    public static $key; // hash key
    public static $iv; // hash iv
    public static $apiUrl; // api url
    public static $apiKey; // api key

    public function __construct()
    {
        self::$apiKey = 'UGr8xp3XBR98uhXCW97frzpTzgFAQ7Nc';
        self::$key = '5gVcDwIseLEDikwg';
        self::$iv  = 'v77hoKGq4kWxNNIS';
        self::$apiUrl  = 'https://www.regal-seal.com/api/';
    }

    public function getKey() {
      return self::$key;
    }

    public function getIv() {
      return self::$iv;
    }

    public function getApiKey() {
      return self::$apiKey;
    }

    public function getUrl($method) {
      return self::$apiUrl. $method;
    }

    public function encryptWithOpenssl($data = '')
    {
        return base64_encode(self::$iv . openssl_encrypt($data, "AES-128-CBC", self::$key, OPENSSL_RAW_DATA, self::$iv));
    }

    public function decryptWithOpenssl($data = '')
    {

        return openssl_decrypt(base64_decode($data), "AES-128-CBC", self::$key, OPENSSL_RAW_DATA, self::$iv);
    }
}
// 使用
/*
$arr = ['status' => '1', 'info' => 'success', 'data' => [['id' => 1, 'name' => '大房间', '2' => '小房间']]];
$str = '{"account":"aapplle123","password":"123456","time":1579174366}';
echo "\n";
echo "{$str}\n";
$obj = new AesWithOpenssl();

$encrypt_str = $obj->encryptWithOpenssl($str);
echo "\n";
echo "{$encrypt_str}\n";
$decrypt_str = $obj->decryptWithOpenssl($encrypt_str);
echo "\n";
echo "{$decrypt_str}\n";
echo "\n";
echo time();
echo "\n";
*/

?>

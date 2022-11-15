<?php

  use \Firebase\JWT\JWT;

  require_once 'libs/jwt/JWT.php';
  require_once 'libs/jwt/BeforeValidException.php';
  require_once 'libs/jwt/ExpiredException.php';
  require_once 'libs/jwt/SignatureInvalidException.php';


  class WF_JWT {

    private const SECRET = 'MDlmNWIyZDU5ZDEzMmN3ddwddfg67NmU2ZDU3MzIyYmYyODJhM2Q5NzlhZkk==';
    private const ALGORITHM = 'HS256';
    private const APIKEY = 'xlagsdjkskdt-sdbasd67gasd7suz-2198zjkjh12i8zhb';


   /*************** JWT Functions  *********************/

    public static function wf_check_BE_Token ($email, $token) {
      try {
        $algsAllowed = array(self::ALGORITHM);
        //
        $decoded = JWT::decode($token, self::SECRET, $algsAllowed);
        // wf_send_report_email("Decoded: " . json_encode($decoded));
        if ($decoded->{'sub'} !== self::APIKEY) {
           // Wrong Token
            $res['status'] = "error";
            $res['errcode'] = "001";
            $res['message'] = "Wrong Token.";          
        } elseif ($decoded->{'email'} !== $email) {
           // Wrong User
            $res['status'] = "error";
            $res['errcode'] = "002";
            $res['message'] = "Token User Mismatch.";
        } else {
           // success
            $res['status'] = "success";
            $res['message'] = "";
        }
    }
    catch (Exception $e) {
        // error, i.e. wrong number of segments or token expired
        $res['status'] = "error";
        $res['errcode'] = "003";
        $res['message'] = $e->getMessage();          
    }
    return $res;
  }


  public static function wf_generate_Token ($email) {

    // Create token header as a JSON string
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

    // Create token payload as a JSON string
    $payload = json_encode(array(
      "iss" => "wappfactory",               // issuer
      "aud" => "de.wappprojects.dev",       // audience, zieldomaine
      "exp" => time() + (86400 * 2 * 365),  // 2 Jahre in sec, UTC !
      "iat" => time(),                      // issued at (now) UTC !
      "email" => $email,
      "sub" => self::APIKEY
    ));

    return (new WF_JWT)->compose_token($header, $payload, self::SECRET);
  }



  private static function compose_token ($header, $payload, $pkey) {
    // Token structure
    // header.payload.signature

    // Encode Header to Base64Url String
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    // Encode Payload to Base64Url String
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    // Create Signature Hash
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $pkey, true);
    // Encode Signature to Base64Url String
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    // Create JWT
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

    return $jwt;

  }
}



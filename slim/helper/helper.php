<?php
    class Helper {


    protected static $_messages = array(
        JSON_ERROR_NONE => 'No error has occurred',
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
        JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
        JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
        JSON_ERROR_SYNTAX => 'Syntax error',
        JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
    );

    # typically used when json_encode returns false because of JSON_ERROR_UTF8 error
    # parses array and changes charset to utf8 for each
    public static function utf8ize($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = (new helper())->utf8ize($value);
            }
        } else if (is_string ($mixed)) {
            return utf8_encode($mixed);
        } else if (is_object($mixed)) {
            $a = (array)$mixed; // from object to array
            return (new helper())->utf8ize($a);
        }
        return $mixed;
    }


    public static function jencode($value, $options = 0) {
        $result = json_encode($value, $options);

        if($result)  {
            return $result;
        } else {
            if (json_last_error() == JSON_ERROR_UTF8) {
                $new_value = (new helper())->utf8ize($value);  
            } 
            $result = (new helper())->jencode($new_value, $options);
            if($result)  {
                return $result;
            }
        }

        throw new RuntimeException(static::$_messages[json_last_error()]);
    }

    public static function jdecode($json, $assoc = false) {
        $result = json_decode($json, $assoc);

        if($result) {
            return $result;
        }

        throw new RuntimeException(static::$_messages[json_last_error()]);
    }


}

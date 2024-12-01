<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl {

    public function __construct() {
        $this->ci =& get_instance();
    }

    public function simple_get($url, $params = array()) {
        $ch = curl_init();
        $url = $url . '?' . http_build_query($params);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            // Log or handle the error
            return "cURL Error: $error";
        }
    
        curl_close($ch);
        return $output;
    }
    

    public function simple_post($url, $data = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}

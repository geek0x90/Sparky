<?php
  namespace Sparky;

  include 'inc/config.php';
  include 'inc/connector.php';

  class Api {
    function __construct() {
      Api::init();
    }

    public static function init() {
      global $_API;
      session_start();

      API::load_modules($_API['directory']);
    }

    public static function request($fields, $assoc = true) {
        global $_API;
        $curl = curl_init($_API{'uri'});
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, $assoc);
    }

    public static function load_modules($dir) { //load the modules in the api directory
      if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
          if ($entry != "." && $entry != ".." && !is_dir($dir.DIRECTORY_SEPARATOR.$entry)) {
            require_once $dir.DIRECTORY_SEPARATOR.$entry;
          }
        }
      }

      closedir($handle);
    }

    public static function core() { //core function for remote api processing
      global $_APP;
      if($_APP['debug'] || isset($_REQUEST['auth']) && isset($_SESSION['auth'])) { //check authentication
        if($_APP['debug'] || $_REQUEST['auth'] == $_SESSION['auth']) {
          if(isset($_REQUEST['callback']) && function_exists($_REQUEST['callback'])) { //check if the callback exists
            $result = isset($_REQUEST['data']) ? $_REQUEST['callback'](Api::secure($_REQUEST['data'])) : $_REQUEST['callback'](); //call the callback with or without the parameters
          }
          else $result = Array('response' => 'error', 'data' => 'Invalid Callback');
        }
        else $result = Array('response' => 'error', 'data' => 'Invalid Authorization');
      }
      else $result = Array('response' => 'error', 'data' => 'Missing Authorization');

      return $result;
    }

    public static function secure($data) { //make the query in the callbacks more secure
      if(is_array($data)) {
          return array_map('addslashes', $data);
      }
      else {
          return secure($data);
      }
    }

    public static function authenticate() { //generate an auth id
      $_SESSION['auth'] = uniqid();
    }

    public static function __callStatic($name, $args) { //caller for loaded modules callbacks in the api directory
      if(function_exists($name)) {
        if(sizeof($args) == 0) {
          //$this->$name();
          return $name();
        }
        else {
          return $name($args[0]);
        }
        //call_user_func_array(array($this,$name), $args);
      }
    }
  }

  Api::init();
?>

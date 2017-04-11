<?php
  namespace Sparky;
  
  class Router{
    /*private $routes;

    function __construct() {
      $this->routes = Array();
    }

    public function route($url = '', $callback = null){
      $this->routes[] = Array('route' => $url, 'callback' => $callback);

    }

    public function core(){
        $myRoute = isset($_GET['route']) ? $_GET['route'] : '';
        $myRoute = substr($myRoute, strlen($myRoute)-1, strlen($myRoute)) == '/' ? substr($myRoute, 0, strlen($myRoute)-1) : $myRoute;

        $myRoutes = explode('/', $myRoute);

        foreach($this->routes as $route) {
          $mRoute = $route['route'];
          $mRoute = substr($mRoute, 0, 1) == '/' ? substr($mRoute, 1, strlen($mRoute)) : $mRoute;

          $mRoutes = explode('/', $mRoute);

          if(count($myRoutes) == count($mRoutes)) {
            $check = true;
            $data = Array();
            for($i = 0; $i < count($myRoutes); $i++) {
              if(substr($mRoutes[$i], 0, 1) == ':') {
                  $data[] = $myRoutes[$i];
              }
              else {
                $check &= $mRoutes[$i] == $myRoutes[$i];
              }
            }

            if($check) {
              return call_user_func_array($route['callback'], $data);
            }
          }
        }
    }*/

    public static function route($url = '', $callback = null){
        $myRoute = isset($_GET['route']) ? $_GET['route'] : '';
        $myRoute = substr($myRoute, strlen($myRoute)-1, strlen($myRoute)) == '/' ? substr($myRoute, 0, strlen($myRoute)-1) : $myRoute;

        $myRoutes = explode('/', $myRoute);

        $route = Array('route' => $url, 'callback' => $callback);

        $mRoute = $route['route'];
        $mRoute = substr($mRoute, 0, 1) == '/' ? substr($mRoute, 1, strlen($mRoute)) : $mRoute;

        $mRoutes = explode('/', $mRoute);

        if(count($myRoutes) == count($mRoutes)) {
          $check = true;
          $data = Array();
          for($i = 0; $i < count($myRoutes); $i++) {
            if(substr($mRoutes[$i], 0, 1) == ':') {
                $data[] = $myRoutes[$i];
            }
            else {
              $check &= $mRoutes[$i] == $myRoutes[$i];
            }
          }

          if($check) {
            return call_user_func_array($route['callback'], $data);
          }
        }
    }
  }
?>

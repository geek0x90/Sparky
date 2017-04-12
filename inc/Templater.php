<?php
  namespace Sparky;
  
  class Templater {
      public static function inflate($scope, $template) {
        $code = file_get_contents($template);

        $result = Templater::inject($scope, $code);

        return $result;
      }

      public static function inject($scope, $code, $infor = 0) {
        if(preg_match_all('/({%\s*for\s+(.+?)\s+in\s+(.+?)\s*%}(.*?){%\s*end\s*%})/s', $code, $matches)) {
          $codeblocks = array_shift($matches);
          $codeblock = array_shift($matches);
          //$codeblock = $codeblock[0];

          for($i = 0; $i < count($matches[0]); $i++) {
            $codeblock = $codeblocks[$i];
            $array = $matches[0][$i];
            $newscope = $matches[1][$i];
            $body = $matches[2][$i];

            $subcode = '';
            foreach($scope[$array] as $subscope) {
              $subscope = Array($newscope => $subscope);
              $subcode .= Templater::inject($subscope, $body, $infor++);
            }

            $subcode = preg_replace('/\s*$/', '', $subcode);
            $code = str_replace($codeblock, $subcode, $code);
          }
        }

        if(preg_match_all('/({%\s*for\s+(\d+?)\s+to\s+(\d+?)\s*%}(.*?){%\s*end\s*%})/s', $code, $matches)) {
          $codeblocks = array_shift($matches);
          $codeblock = array_shift($matches);
          //$codeblock = $codeblock[0];

          for($i = 0; $i < count($matches[0]); $i++) {
            $codeblock = $codeblocks[$i];
            $from = $matches[0][$i];
            $to = $matches[1][$i];
            $body = $matches[2][$i];

            $subcode = '';
            for($c = $from; $c < $to; $c++) {
              $subscope = Array($newscope => $subscope);
              $subcode .= Templater::inject($subscope, $body, $c);
            }

            $subcode = preg_replace('/\s*$/', '', $subcode);
            $code = str_replace($codeblock, $subcode, $code);
          }
        }

        if(preg_match_all('/({%\s*(.*?)\s*%})/', $code, $matches)) {
          $matches = $matches[1];

          foreach($matches as $match) {
            $tag = $match;
            $match = preg_replace('/^{%\s*/', '', $match);
            $match = preg_replace('/\s*%}$/', '', $match);

            $var = explode('.', $match);

            if(count($var) > 1) {
              if(isset($scope[$var[0]])) {
                $scopevar = $scope[$var[0]];
                if(is_numeric($var[1])) {
                  $code = str_replace($tag, $scopevar[(int) $var[1]], $code);
                }
                else {
                  $code = str_replace($tag, $scopevar[$var[1]], $code);
                }
              }
            }
            else {
              if(isset($scope[$match])) {
                $code = str_replace($tag, $scope[$match], $code);
              }
              else {
                if($match == '_') {
                  $code = str_replace($tag, $infor, $code);
                }
              }
            }
          }
        }


        return $code;
    }
  }
?>

<?php
/*!
 * Lightsome
 * Copyright (C) 2012-2016 David Andrei.
 * https://github.com/davidmoraru/lightsome
 *
 * Lightsome is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; version 3 only.
 *
 * Lightsome is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Lightsome. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Shortcut to the Som::get() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function get($route, $function)
{
    Light\Some::get($route, $function);
}

/**
 * Shortcut to the Some::post() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function post($route, $function)
{
    Light\Some::post($route, $function);
}

/**
 * Shortcut to the Som::put() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function put($route, $function)
{
    Light\Some::put($route, $function);
}

/**
 * Shortcut to the Som::patch() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function patch($route, $function)
{
    Light\Some::patch($route, $function);
}

/**
 * Shortcut to the Som::delete() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function delete($route, $function)
{
    Light\Some::delete($route, $function);
}
function app($s = null) {
    if($s === null) {
       return getenv('APP_NAME');
    } else {
       $setting = strtoupper('APP_' . $s);
       return getenv($setting) ? getenv($setting) : '<span style="color: #f14668;"><em>null</em></span>';
    }
 }
 function actual() {
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
 }
 function deleteNonEmptyDir($dir) 
 {
    if (is_dir($dir)) 
    {
         $objects = scandir($dir);
 
         foreach ($objects as $object) 
         {
             if ($object != "." && $object != "..") 
             {
                 if (filetype($dir . "/" . $object) == "dir")
                 {
                     deleteNonEmptyDir($dir . "/" . $object); 
                 }
                 else
                 {
                     unlink($dir . "/" . $object);
                 }
             }
         }
 
         reset($objects);
         rmdir($dir);
     }
 }
 function view($view, $args = []) {
    View::render($view, $args);
 }
 function db_path() {
    return realpath(__DIR__).'/../Db/data/';
 }
 function app_path() {
    return realpath(__DIR__).'/..//';
 }
 function asset_path($asset = '') {  
    if($asset) {
       return realpath(__DIR__) . '/../../public/' . $asset;
    }
    return realpath(__DIR__) . '/../../public/';
    
 }
  
 function vesc($value){
      return View::e($value);
 }

  // helper function
 function e($e=null) {
    echo $e;
 }
 function h($h=null) {
    echo(htmlspecialchars($h));
 }
 function b($b=null) {
    echo('<b>'.$b.'</b>');
 }
 function assets($path = '', $cdn) {
    if($path) {
       if ($path[0] != '/') {
          return $cdn . '/' . $path;
       } else {
          return $cdn . $path;
       }
    } else {
       return $cdn;
    }
 }
 
 function errorpage($status) {
    if($status == 404) {
       return [
          "status" => $status,
          "title" => "Page Not Found",
          "message" => "The page you are looking for might have been removed, expired or is temporarily unavailable."
      ];
    } else if($status === 700) {
       return [
          "status" => $status,
          "title" => "No API Credentials",
          "message" => "Check you api credentials and try again. You should check your .env file and be sure to have the api & application keys completed"
      ];
    } else if($status === 801) {
       return [
          "status" => $status,
          "title" => "Reservation not possible",
          "message" => "You can only have one booking at a time. Contact the property owner and let him know that you made a booking on this property so he can accept / deny the booking request."
      ];
    } else if($status === 417) {
       return [
          "status" => $status,
          "title" => "Reservation Error",
          "message" => "The property you are trying to make a reservation might have been removed, expired or is unavailable."
      ];
    } else if($status === 418) {
       return [
          "status" => $status,
          "title" => "Booking Expired",
          "message" => "The booking you are looking for might have been removed, expired or is unavailable."
      ];
    } else if($status === 419) {
       return [
          "status" => $status,
          "title" => "Session Expired",
          "message" => "The page you are looking for might have been removed, expired or is temporarily unavailable."
      ];
    } else if($status === 301) {
       return [
          "status" => $status,
          "title" => "Page is not available",
          "message" => "The page you are looking for might have been removed, expired or is temporarily unavailable."
      ];
    } else if($status === 318) {
       return [
          "status" => $status,
          "title" => "Session Cleared",
          "message" => "The page you are looking for might have been removed, expired or is temporarily unavailable."
      ];
    } else if($status === 909) {
       return [
          "status" => $status,
          "title" => "Page Disabled",
          "message" => "The page you are looking for might have been disabled, expired or is temporarily unavailable."
      ];
    } else {
       return [
          "status" => 500,
          "title" => "Server Not Responding",
          "message" => "The page you are looking for might have been removed, expired or is temporarily unavailable."
      ];
    }
 }
 function url($path = '') {
    if(isset($_SERVER['REQUEST_SCHEME'])) {
       $scheme = $_SERVER['REQUEST_SCHEME'];
    } else {
       $scheme = (($_SERVER['HTTPS'] == "on") ? 'https' : 'http');
    }
    if($path) {
       if ($path[0] != '/') {
          $do = $scheme . '://' . $_SERVER['HTTP_HOST'] . '/' . $path;
       } else {
          $do = $scheme . '://' . $_SERVER['HTTP_HOST'] . $path;
       }
    } else {
       $do = $scheme . '://' . $_SERVER['HTTP_HOST'];
    }
    return $do;
 }
 function slugify($string) {
    return trim(preg_replace('/[^A-Za-z0-9-]+/', '-', ucwords($string)), '-');
}
function redirect($path = '') {
   if($path) {
    header('Location:' . url($path));
   } else {
    header('Location:' . url('error/404'));
   }
}

 function storage($file, $type) {
    $file = dirname( __FILE__, 2 ) .'/Storage/assets/' . $type . '/' . $file . '.' . $type;
       if(!is_file($file)){
          file_put_contents($file, "\n\t");
       }
    return $file;
 }
 function css($file = 'custom') {
    return "<style type=\"text/css\">\n" . file_get_contents(storage($file, 'css')) . "\n</style>\n";
 }
 function js($file = 'custom') {
    return "<script type=\"text/javascript\">\n" . file_get_contents(storage($file, 'js')) . "\n</script>\n";
 }

 function plural($no, $str) {
    if($no != 1) {
       $str = $str . 's';
    }
    return $str;
 }
 function str_plural($no, $str) {
    if($no != 1) {
       return $no . '&nbsp;' . $str . 's';
    }
    return $no . '&nbsp;' . $str;
 }
 function str_plurald($no, $str) {
    if($no != 1) {
       return $no . ' ' . $str . 's';
    }
    return $no . ' ' . $str;
 }
 function randStr($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return strtoupper($randomString);
}
function obfuscateEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $ex = explode('@', $email);
       $com = explode('.', $ex[1]);
       $len = strlen($com[0]);
       $asterix = str_repeat("*", $len);
       return str_replace($ex[1], $asterix, $email) . '.' . $com[1];
    } else {
       return 'No a valid email';
    }
 }


 function temp_assets($file = '/') {
    return url('/app/Storage/assets' . $file);
 }
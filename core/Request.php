<?php

  namespace app\core;

  class Request 
  {
    public function getPath()
    {
      $path = $_SERVER["REQUEST_URI"] ?? "/";

      $position = strpos($path, "?");

      //this means that we dont have ? mark in url
      if ($position === false)
      {
        return $path;
      }

      return substr($path, 0, $position);
    }

    public function getMethod() 
    {
      //request method will be get or post
      return strtolower($_SERVER["REQUEST_METHOD"]);
    }
  }
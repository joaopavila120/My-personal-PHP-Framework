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

    public function method() 
    {
      //request method will be get or post
      return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function isGet()
    {
      return $this->method() === "get";
    }

    public function isPost()
    {
      return $this->method() === "post";
    }

    public function getBody()
    {
      $body = [];

      if ($this->method() === "get")
      {
        //to sanitize
        foreach ($_GET as $key => $value)
        {
          $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
      }

      if ($this->method() === "post") 
      {
        //to sanitize
        foreach ($_POST as $key => $value) {
          $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
      }

      return $body;
    }
  }
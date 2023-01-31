<?php

namespace app\core;
/**
 * @author joao.avila
 * @package app\core
 */
class Application
  {
      public Router     $router;
      public Request    $request;
      public Response   $response;
      public Controller $controller;
      public Database   $db;

      public static Application $app;
      public static string      $ROOT_DIR;

      public function __construct($rootPath, array $DBConfig)
      {
        self::$ROOT_DIR = $rootPath;   
        self::$app      = $this;

        $this->request  = new Request();
        $this->response = new Response();
        $this->router   = new Router($this->request, $this->response);

        $this->db = new Database($DBConfig["db"]);
      }

      public function run() 
      {
       echo $this->router->resolve();
      }

      public function getController()
      {
        return $this->controller;
      }

      public function setController($controller)
      {
        $this->controller = $controller;
      }
  }
<?php
  namespace app\controllers;

  use app\core\Application;
  use app\core\Controller;
  use app\core\Request;

  /**
   * @author joao.avila
   * @package app\controllers
   */
  class SiteController extends Controller
  {

   //render view from here, cause sometimes we want to pass parameters
    public function home()
    {
      $params = [
        "name" => "JoaoPaulo"
      ];

      return $this->render("home", $params);
    }

    public function contact()
    {
      //in application::$app we have the router
      return $this->render("contact");
    }

    public function register()
    {
      //in application::$app we have the router
      return $this->render("register");
    }

    public function login()
    {
      //in application::$app we have the router
      return $this->render("login");
    }

    public static function handleContact(Request $request)
    {
      $body = $request->getBody();

      return "Handling submitted data";
    }
  }


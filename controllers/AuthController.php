<?php
  namespace app\controllers;

  use app\core\Application;
  use app\core\Controller;
  use app\core\Request;

  /**
   * @author joao.avila
   * @package app\controllers
   */
  class AuthController extends Controller
  {
    public function login()
    {
      $this->setLayout("auth");
      return $this->render("login");
    }

    public function register(Request $request)
    {
      if ($request->isPost())
        return "handle submitted data";

      $this->setLayout("auth");
      return $this->render("register");
    }
  }
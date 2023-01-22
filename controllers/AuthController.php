<?php
  namespace app\controllers;

  use app\core\Application;
  use app\core\Controller;
  use app\core\Request;
  use app\models\RegisterModel;

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
      $registerModel = new RegisterModel();

      if ($request->isPost())
      {
        //here we are getting the form
        $registerModel->loadData($request->getBody());

        if ($registerModel->validate() && $registerModel->register())
          return "Success";

        return $this->render("register", [
          "model" => $registerModel
        ]);
      }

      return $this->render("register", [
        "model" => $registerModel
      ]);
    }
  }
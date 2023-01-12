<?php

  namespace app\core;

    /**
     * @author joao.avila
     * @package app\core
     */
    class Router
    {
      public Request  $request;
      public Response $response;
      protected array $routes = [];

      /**
       * @param \app\core\Request $request
       */
      public function __constructor(Request $request, Response $response)
      {
        $this->response = $response;
        $this->request  = $request;
      }

      public function get($path, $callback)
      {
        $this->routes["get"][$path] = $callback;
      }

      public function post($path, $callback)
      {
        $this->routes["post"][$path] = $callback;
      }

      public function resolve()
      {
        //TODO o certo é tirar o novo instanciamento, porem so assim esta funcionando (investigar depois) 
        $this->request  = new Request();
        $this->response = new Response();

        $path     = $this->request->getPath();
        $method   = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false)
        {
          Application::$app->response->setStatusCode(404);
          return $this->renderView("_404");
        }
        
        //if its a string, it assumes it is a view
        if (is_string($callback))
          return $this->renderView($callback);
        
        if (is_array($callback))
        {
          //callback[0] is the controller name, this is for use $this->render in SiteController, is the instance of controller
          Application::$app->controller = new $callback[0]();
          $callback[0]                  = Application::$app->controller;
        }
        
        return call_user_func($callback, $this->request);
      }

      public function renderView($view, $params = [])
      {
        //render view inside the layout
        $layoutContent = $this->layoutContent();
        $viewContent   = $this->renderOnlyView($view, $params);
        
        return str_replace("{{content", $viewContent, $layoutContent);  
      }

      public function renderContent($viewContent)
      {
        //render view inside the layout
        $layoutContent = $this->layoutContent();

        return str_replace("{{content", $viewContent, $layoutContent);
      }

      protected function layoutContent()
      {
        $layout = Application::$app->controller->layout;

        //start cache output
        ob_start();

        include_once(Application::$ROOT_DIR . "/views/layouts/$layout.php");

        //clear the buffer
        return ob_get_clean();
      }

      protected function renderOnlyView($view, $params = [])
      {
        foreach ($params as $key => $value)
        {
          //create a variable 
          $$key = $value;
        }

        //start cache output
        ob_start();

        include_once(Application::$ROOT_DIR . "/views/{$view}.php");

        //clear the buffer
        return ob_get_clean();
      }
    }
<?php

  namespace app\core;

    /**
     * @author joao.avila
     * @package app\core
     */
    class Router
    {
      public Request $request;
      protected array $routes = [];

      /**
       * @param \app\core\Request $request
       */
      public function __constructor(\app\core\Request $request)
      {
        $this->request = $request;
      }

      public function get($path, $callback)
      {
        $this->routes["get"][$path] = $callback;
      }

      public function resolve()
      {
        $this->request = new Request();
        $path = $this->request->getPath();

        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback)
        {
          echo "Not found";
          exit;
        }
          
        echo call_user_func($callback);
      }
    }
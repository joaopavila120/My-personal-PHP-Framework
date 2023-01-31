<?php
    require_once __DIR__."/../vendor/autoload.php";

    use app\controllers\AuthController;
    use app\controllers\SiteController;
    use app\core\Application;


    //https://github.com/vlucas/phpdotenv - use this lib to load variables inside .env
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    
    //Database config
    $DBConfig = [
      "db" => [
        "dsn"      => $_ENV["DB_DSN"],
        "user"     => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"]
      ]
    ];

    $app = new Application(dirname(__DIR__), $DBConfig);

    $app->router->get("/",         [SiteController::class, "home"]);
    $app->router->get("/contact",  [SiteController::class, "contact"]);
    $app->router->post("/contact", [SiteController::class, "handleContact"]);

    $app->router->get("/login",     [AuthController::class, "login"]);
    $app->router->post("/login",    [AuthController::class, "login"]);
    $app->router->get("/register",  [AuthController::class, "register"]);
    $app->router->post("/register", [AuthController::class, "register"]);

    $app->run();
?>
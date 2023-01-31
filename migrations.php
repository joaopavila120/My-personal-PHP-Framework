<?php
/**
 * User: joao.avila
 * Date: 1/23/2023
 * Time: 11:13 p.m 
 */
    require_once __DIR__."/vendor/autoload.php";

    use app\controllers\AuthController;
    use app\controllers\SiteController;
    use app\core\Application;


    //https://github.com/vlucas/phpdotenv - use this lib to load variables inside .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    //Database config
    $DBConfig = [
      "db" => [
        "dsn"      => $_ENV["DB_DSN"],
        "user"     => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"]
      ]
    ];

    $app = new Application(__DIR__, $DBConfig);

$app->db->applyMigrations();
?>
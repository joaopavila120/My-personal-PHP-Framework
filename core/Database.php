<?php

namespace app\core;

/**
 * Create and run initials SQL
 * @author joao.avila
 * @package app\core
 */

 class Database 
 {
  public \PDO $pdo;

  public function __construct(array $config)
  {
    $dsn      = $config["dsn"]      ?? "";
    $user     = $config["user"]     ?? "";
    $password = $config["password"] ?? "";

    //dsn - domain service name
    $this->pdo = new \PDO($dsn, $user, $password);

    //this means if there is some problem connecting to de database throw an exception
    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }

  public function applyMigrations()
  {
    $this->createMigrationsTable();
    $appliedMigrations = $this->getAppliedMigrations();

    $newMigrations = [];
    $files = scandir(Application::$ROOT_DIR . "/migrations");

    $toApplyMigrations = array_diff($files, $appliedMigrations);

    foreach ($toApplyMigrations as $migration)
    {
      if ($migration === "." || $migration === "..")
        continue;

      require_once Application::$ROOT_DIR . "/migrations/".$migration;

      //classname is the classes that are inside migrations folder
      $className = pathinfo($migration, PATHINFO_FILENAME);
      $instance = new $className();
      $this->log("Applying migration $migration");
      $instance->up();
      $this->log("Applied migration $migration");
      $newMigrations[] = $migration;
    

    if (!empty($newMigrations))
      $this->saveMigrations($newMigrations);
    else
      $this->log("All migrations are applied");

    }
  }

  public function createMigrationsTable()
  {

    $migrationSQL = <<<SQL
    CREATE TABLE IF NOT EXISTS migrations(
        id_migration  INT AUTO_INCREMENT PRIMARY KEY,
        ds_migration  VARCHAR(255),
        dt_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      ) ENGINE=INNODB;
    SQL;

    $this->pdo->exec($migrationSQL);
  }

  public function getAppliedMigrations()
  {
    $getAppliedMigrationSQL = <<<SQL
      SELECT ds_migration FROM migrations 
    SQL;

    $statement = $this->pdo->prepare($getAppliedMigrationSQL);
    $statement->execute();

    //fetch every migraton column values as a single dimention array
    return $statement->fetchAll(\PDO::FETCH_COLUMN);
  }

  public function saveMigrations(array $migrations)
  {
    //get the file name like 'm001_initial.php' and turn like "('m0001_initial.php')"
    $migrationString = implode(",", array_map(fn($m) => "('$m')", $migrations));

    // ex: INSERT INTO migrations (ds_migration) VALUES ('m0001_initital.php'), ('m0002_something.php');
    $statement = $this->pdo->prepare("
      INSERT INTO migrations (ds_migration) VALUES 
      $migrationString
      ");

     $statement->execute();
  }

  protected function log($message)
  {
    echo "[".date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL; 
  }
 }
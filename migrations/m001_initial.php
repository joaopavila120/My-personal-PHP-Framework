<?php

use app\core\Application;

/**
 * User: joao.avila
 * Date: 1/23/2023
 * Time: 11:10 p.m 
 */

 class m001_initial 
 {
  
  public function up()
  {
    $db = \app\core\Application::$app->db;

    $sql = <<<SQL
      CREATE TABLE users (
        id_user      INT NOT NULL AUTO_INCREMENT, 
        ds_password  VARCHAR(512) NOT NULL,
        ds_email     VARCHAR(255) NOT NULL,
        ds_firstname VARCHAR(255) NOT NULL, 
        ds_lastname  VARCHAR(255) NOT NULL,
        id_status    TINYINT NOT NULL,
        dt_created   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id_user)
      ) ENGINE=INNODB;
    SQL;

    $db->pdo->exec($sql);
  }

  //reverse if up
  public function down() 
  {
    echo "down migration";
  }
 }
<?php

namespace App;


class Database
{

  /**
   * connection variaable
   */
  public $con;

  public function __construct()
  {
    new Config;

    try {
      // Create a connection to the database
      $this->con = new \mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD);

      // Check if the connection was successful
      if ($this->con->connect_error) {
        throw new \Exception("Unable to connect to server: " . $this->con->connect_error);
      }

      // Initilize the table
      $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;

      $result = $this->con->query($sql);

      if (!$result) {
        throw new \Exception("Unable to Connect to Database.");
      } else {
        $this->con->select_db(DB_NAME);
      }

    } catch (\Exception $e) {
      $_SESSION['session_alert'] = "<script>alert('Ooops : " . addslashes($e->getMessage()) . "');</script>" . "<script>window.location.href = '/register';</script>";
    }

  }

  protected function create_table_if_not_exist($table_name, $sql)
  {
    try {

      $result = $this->con->query($sql);

      if (!$result) {
        throw new \Exception("Unable to Create $table_name table.");
      }
    } catch (\Exception $e) {
      echo "<script>alert('Ooops : " . addslashes($e->getMessage()) . "');</script>";
      echo "<script>window.location.href = '/home';</script>";
    }

  }

}



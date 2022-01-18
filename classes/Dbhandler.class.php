<?php 

class Dbhandler {

  protected function connect() {
    try {
      $username = "root";
      $password = "";
      $dbh = new PDO('mysql:host=localhost;dbname=ogtech', $username, $password);
      return $dbh;
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
  }
}
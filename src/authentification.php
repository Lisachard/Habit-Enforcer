<?php

class BDD
{

    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dataname = "habit-enforcer";
    private $database;

    public function __construct() {
        try {
            $this->database = new PDO("mysql:host=$this->host;dbname=$this->dataname", $this->user, $this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function add() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $this->database->exec($sql);
    }
}

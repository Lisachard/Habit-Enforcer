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

    public function addMember() {
        $sql = "INSERT INTO Membre (member_id, pseudo, email, password, group_id) VALUES (?, ?, ?, ?, ?)";
        $sentence = $this->database->prepare($sql);

        $username = strip_tags($_POST['username']);
        $email = strip_tags($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        try {
            $sentence->execute([uniqid(), $username, $email, $password, NULL]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function loginMember() {
        $sql = "SELECT * FROM Membre WHERE email = ?";
        $sentence = $this->database->prepare($sql);

        $identifiant = strip_tags($_POST['identifiant']);
        
        try {
            $sentence->execute([$identifiant, $identifiant]);
            $result = $sentence->fetch();
            if (password_verify($_POST['password'], $result['password'])) {
                echo "TRUE";
            } else {
                echo "FALSE";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }
}

$bdd = new BDD();

if (isset($_POST['register'])) {
    $bdd->addMember();
}

if (isset($_POST['login'])) {
    $bdd->loginMember();
}

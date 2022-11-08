<?php session_start();

function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}


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
        $sql = "INSERT INTO Membre (member_id, pseudo, email, password, profile_picture, group_id) VALUES (?, ?, ?, ?, ?, ?)";
        $sentence = $this->database->prepare($sql);

        $username = strip_tags($_POST['username']);
        $email = strip_tags($_POST['email']);
        
        if($_POST['password'] == $_POST['confirmPassword']) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            echo "Mauvaise Recopie du mdp";
            die;
        }
        
        try {
            $sentence->execute([uniqid(), $username, $email, $password, "https://source.boringavatars.com/marble/", NULL]);
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
            $sentence->execute([$identifiant]);
            $result = $sentence->fetch();
            if (password_verify($_POST['password'], $result['password'])) {
                $_SESSION['LOGGED_USER'] = true;
                $_SESSION['profile_picture'] = $result['profile_picture'];
                $_SESSION['pseudo'] = $result['pseudo'];
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
    Redirect("./login.php", true);
}

if (isset($_POST['login'])) {
    $bdd->loginMember();
    Redirect("./home.php");
}

if (isset($_POST['deconnexion'])) {
    session_destroy();
    Redirect("./home.php");
}

?>
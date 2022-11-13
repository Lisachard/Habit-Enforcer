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
        $sql = "INSERT INTO Member (member_id, pseudo, email, password, profile_picture, party_id) VALUES (?, ?, ?, ?, ?, ?)";
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
            $sentence->execute([uniqid(), $username, $email, $password, "https://source.boringavatars.com/marble/300/", NULL]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function createParty() {
        $sql = "INSERT INTO Party (score) VALUES (?)";
        $sentence = $this->database->prepare($sql);
        
        $sentence->execute([0]);

        $_SESSION['party_id'] = $this->database->lastInsertId();

        echo "<script>console.log('Debug Objects: " . $_SESSION['party_id'] . "' );</script>";
        
        $sql = "UPDATE Member SET party_id = " . $_SESSION['party_id'] . " WHERE member_id = ?";
        $sentence = $this->database->prepare($sql);

        $sentence->execute([$_SESSION['member_id']]);
    }

    public function loginMember() {
        $sql = "SELECT * FROM Member WHERE email = ?";
        $sentence = $this->database->prepare($sql);

        $identifiant = strip_tags($_POST['identifiant']);
        
        try {
            $sentence->execute([$identifiant]);
            $result = $sentence->fetch();
            if (password_verify($_POST['password'], $result['password'])) {
                $_SESSION['LOGGED_USER'] = true;
                $_SESSION['member_id'] = $result['member_id'];
                $_SESSION['profile_picture'] = $result['profile_picture'];
                $_SESSION['pseudo'] = $result['pseudo'];
                $_SESSION['party_id'] = $result['party_id'];
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
    Redirect("./home.php", true);
}

if (isset($_POST['deconnexion'])) {
    session_destroy();
    Redirect("./home.php", true);
}

if (isset($_POST['createParty'])) {
    $bdd->createParty();
}
?>
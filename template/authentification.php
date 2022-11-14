<?php session_start();

function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

class BDD
{

    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dataname = "habit-enforcer";
    private $database;

    public function __construct()
    {
        try {
            $this->database = new PDO("mysql:host=$this->host;dbname=$this->dataname", $this->user, $this->password);
            $this->database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function addMember()
    {
        $sql = "INSERT INTO Member (member_id, pseudo, email, password, profile_picture, party_id) VALUES (?, ?, ?, ?, ?, ?)";
        $sentence = $this->database->prepare($sql);

        $username = strip_tags($_POST['username']);
        $email = strip_tags($_POST['email']);

        if ($_POST['password'] == $_POST['confirmPassword']) {
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

    public function createParty()
    {
        // create the party
        $sql = "INSERT INTO Party (score) VALUES (?)";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([0]);

        // add the chef to the party
        $_SESSION['party_id'] = $this->database->lastInsertId();
        $sql = "UPDATE Member SET party_id = ? WHERE member_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_SESSION['party_id'], $_SESSION['member_id']]);
    }

    public function inviteToTheParty()
    {
    }

    public function addHabit()
    {
        $sql = "INSERT INTO Habit (label, difficulty, color, member_id) VALUES (?, ?, ?, ?)";
        $sentence = $this->database->prepare($sql);
        $label = strip_tags($_POST['label']);
        $difficulty = strip_tags($_POST['difficulty']);
        $color = strip_tags($_POST['color']);
        $sentence->execute([$label, $difficulty, $color, $_SESSION['member_id']]);
    }

    public function readHabit()
    {
        $sql = "SELECT * FROM Habit WHERE member_id = ?";
        $sentence = $this->database->prepare($sql);

        $sentence->execute([$_SESSION['member_id']]);
        // fetch "sans index" 😉
        $sentence->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sentence->fetchall();
        foreach ($result as $row) {
            echo '<div style="background-color:' . $row['color'] . '">' . $row['label'] . '</div>';
        }
    }

    public function searchFriend()
    {
        $sql = "SELECT * FROM Member WHERE pseudo LIKE :search";

        $sentence = $this->database->prepare($sql);

        $search = '%' . strip_tags($_GET['searching']) . '%';
        $sentence->bindParam(":search", $search);
        $sentence->execute();
        // fetch "sans index" 😉
        $sentence->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sentence->fetchAll();
        foreach ($result as $row) {
            echo '<div class="card">' . $row['pseudo'] . '<button type="submit" name="membre" value=' . $row['member_id'] . '>Add</button>' . '</div>';
            debug_to_console($row);
        }
    }

    public function loginMember()
    {
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
}

if (isset($_POST['createParty'])) {
    $bdd->createParty();
}

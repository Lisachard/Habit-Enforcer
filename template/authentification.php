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

$temps = date('d/m/Y @ H:i');

debug_to_console($temps);

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
        $sql = "INSERT INTO Party (name, score) VALUES (?, ?)";
        $sentence = $this->database->prepare($sql);

        $name = "";
        
        if (isset($_POST['partyName'])) {
            $name = strip_tags($_POST['partyName']);
        } else {
            $name = $_SESSION['pseudo'] . "'s Party";
        }
        
        $sentence->execute([$name, 0]);

        // add the chef to the party
        $_SESSION['party_id'] = $this->database->lastInsertId();
        $_SESSION['party_name'] = $name;
        $sql = "UPDATE Member SET party_id = ? WHERE member_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_SESSION['party_id'], $_SESSION['member_id']]);
    }

    public function inviteToTheParty() {
        $sql = "SELECT email FROM Member WHERE member_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_POST['membre']]);
        $result = $sentence->fetch();
        
        $sql = "INSERT INTO Invitation (email, invite_party_id) VALUES (?, ?)";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$result['email'], $_SESSION['party_id']]);
        
    }

    public function joinParty() {
        // Join the party
        $sql = "UPDATE Member SET party_id = ? WHERE member_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_POST['party'], $_SESSION['member_id']]);
        $_SESSION['party_id'] = $_POST['party'];

        // Get the party name
        $sql = "SELECT * Party WHERE party_id = ?";
        $sentence = $this->database->prepare($sql);
        
        $sentence->execute([$_SESSION['party_id']]);

        $result = $sentence->fetch();
        $_SESSION['party_name'] = $result['name'];
    }

    public function addHabit()
    {
        $sql = "INSERT INTO Habit (label, difficulty, color, member_id, is_daily) VALUES (?, ?, ?, ?, ?)";
        $sentence = $this->database->prepare($sql);
        $label = strip_tags($_POST['label']);
        $difficulty = strip_tags($_POST['difficulty']);
        $color = strip_tags($_POST['color']);
        if ($_POST['periodicity'] == "daily") {
            $is_daily = 1;
        } else {
            $is_daily = 0;
        }
        $sentence->execute([$label, $difficulty, $color, $_SESSION['member_id'], $is_daily]);
    }

    public function readHabit()
    {
        $sql = "SELECT * FROM Habit WHERE member_id = ?";
        $sentence = $this->database->prepare($sql);

        $sentence->execute([$_SESSION['member_id']]);
        // fetch "sans index" 😉
        $sentence->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sentence->fetchall();
        return $result;
    }

    public function alreadyCreateHabit()
    {
        $sql = "SELECT * FROM Habit WHERE member_id = ? AND created_at BETWEEN CURDATE() AND CURDATE() + INTERVAL 1 DAY";
        $sentence = $this->database->prepare($sql);

        $sentence->execute([$_SESSION['member_id']]);
        // fetch "sans index" 😉
        $sentence->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sentence->fetchall();
        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    public function leaveParty() {
        $sql = "UPDATE Member SET party_id = NULL WHERE member_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_SESSION['member_id']]);
        $_SESSION['party_id'] = NULL;
        $_SESSION['party_name'] = NULL;

        // Delete the party if he is the last member
        $sql = "SELECT * FROM Member WHERE party_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_SESSION['party_id']]);
        $sentence->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sentence->fetchall();
        if (empty($result)) {
            $this->destroyParty();
        }
    }

    public function searchFriend()
    {
        $sql = "SELECT * FROM Member WHERE pseudo LIKE :search AND NOT member_id = :id AND party_id IS NULL";

        $sentence = $this->database->prepare($sql);

        $search = '%' . strip_tags($_GET['searching']) . '%';
        $sentence->bindParam(":search", $search);
        $sentence->bindParam(":id", $_SESSION['member_id']);
        $sentence->execute();
        // fetch "sans index" 😉
        $sentence->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sentence->fetchAll();
        foreach ($result as $row) {
            echo '<div class="card">' . $row['pseudo'] . '<button type="submit" name="membre" value=' . $row['member_id'] . '>Add</button>' . '</div>';
        }
    }

    public function loginMember()
    {
        $sql = "SELECT * FROM member LEFT JOIN Invitation ON member.email = Invitation.email LEFT JOIN Party ON member.party_id = Party.party_id WHERE member.email = ?";
        $sentence = $this->database->prepare($sql);

        $identifiant = strip_tags($_POST['identifiant']);
        $_SESSION['invitation_party_id'] = [];
        $_SESSION['invitation_party_name'] = [];
        

        try {
            $sentence->execute([$identifiant]);
            $result = $sentence->fetchall();
            foreach ($result as $row) {
                if (password_verify($_POST['password'], $row['password'])) {
                    $_SESSION['LOGGED_USER'] = true;
                    $_SESSION['member_id'] = $row['member_id'];
                    $_SESSION['profile_picture'] = $row['profile_picture'];
                    $_SESSION['pseudo'] = $row['pseudo'];
                    $_SESSION['party_id'] = $row['party_id'];
                    $_SESSION['party_name'] = $row['name'];
                    array_push($_SESSION['invitation_party_id'], $row['invite_party_id']);
                    array_push($_SESSION['invitation_party_name'], $row['name']);
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function checkNewDay()
    {
        $sql = "SELECT * FROM Habit";
        $sentence = $this->database->prepare($sql);

        $sentence->execute();
        // fetch "sans index" 😉
        $sentence->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sentence->fetchall();
        foreach ($result as $row) {
            if ($row['created_at'] < date('Y-m-d')) {
                $sql = "UPDATE Habit SET created_at = CURDATE() WHERE habit_id = ?";
                $sentence = $this->database->prepare($sql);
                $sentence->execute([$row['habit_id']]);
            }
        }   
    }

    public function addScore() {
        $sql = "UPDATE Party SET score = score + 1 * ? WHERE party_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_POST['difficulty'], $_SESSION['party_id']]);

        $sql = "UPDATE habit SET checked = 1 WHERE habit_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_POST['notchecked']]); 

    }

    public function removeScore() {
        $sql = "UPDATE Party SET score = score - 1 * ? WHERE party_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_POST['difficulty'], $_SESSION['party_id']]);
        
        $sql = "UPDATE habit SET checked = 0 WHERE habit_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_POST['checked']]);

        $sql = "SELECT score FROM Party WHERE party_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_SESSION['party_id']]);
        $sentence->setFetchMode(PDO::FETCH_ASSOC);
        $result = $sentence->fetch();
        if ($result['score'] < 0) {
            $sql = "UPDATE Member SET party_id = NULL WHERE party_id = ?";
            $sentence = $this->database->prepare($sql);
            $sentence->execute([$_SESSION['party_id']]);
            $this->destroyParty();
        }
    }

    public function destroyParty() {
        
        $sql = "DELETE FROM Party WHERE party_id = ?";
        $sentence = $this->database->prepare($sql);
        $sentence->execute([$_SESSION['party_id']]);
        $_SESSION['party_id'] = NULL;
        $_SESSION['party_name'] = NULL;
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
    Redirect("./login.php", true);
}

if (isset($_POST['createParty'])) {
    $bdd->createParty();
}

if (isset($_POST['membre'])) {
    $bdd->inviteToTheParty();
}

if (isset($_POST['party'])) {
    $bdd->joinParty();
}

if (isset($_POST['leaveParty'])) {
    $bdd->leaveParty();
    Redirect("./home.php", true);
}

if (isset($_POST['notchecked'])) {
    $bdd->addScore();
}

if (isset($_POST['checked'])) {
    $bdd->removeScore();
}

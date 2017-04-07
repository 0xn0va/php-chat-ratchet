<?php

require_once 'config.php';

class main
{
    private $con;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->con = $db;
    }

    public function hashsalt()
    {
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $salt = sprintf("$2a$%02d$", $cost) . $salt;
        return $salt;
    }

    public function runQuery($sql)
    {
        $result = $this->con->prepare($sql);
        return $result;
    }

    public function lastID()
    {
        $result = $this->con->lastInsertId();
        return $result;
    }

    public function form($username, $email, $password, $salt, $verification)
    {
        try {
            $password = crypt($password, $salt);
            $result = $this->con->prepare("INSERT INTO users(u_Name,u_Email,u_Pass, verif_Code)
			                                             VALUES(:username, :email, :password, :verification)");
            $result->bindparam(":username", $username);
            $result->bindparam(":email", $email);
            $result->bindparam(":password", $password);
            $result->bindparam(":verification", $verification);
            $result->execute();
            return $result;
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }

    public function login($email, $password)
    {
        try {
            $result = $this->con->prepare("SELECT * FROM users WHERE u_Email=:email_id");
            $result->execute(array(":email_id" => $email));
            $userRow = $result->fetch(PDO::FETCH_ASSOC);
            $passhash = $userRow['u_Pass'];
            if ($result->rowCount() == 1) {
                if ($userRow['u_Status'] == "Y") {
                    if ($passhash == crypt($password, $passhash)) {
                        $_SESSION['userSession'] = $userRow['u_ID'];
                        return true;
                    } else {
                        header("Location: index.php?error");
                        exit;
                    }
                } else {
                    header("Location: index.php?inactive");
                    exit;
                }
            } else {
                header("Location: index.php?error");
                exit;
            }
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }

    public function is_logged_in()
    {
        if (isset($_SESSION['userSession'])) {
            return true;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }

    function send_mail($email, $message, $subject)
    {
        require_once('resources/phpmailer/PHPMailerAutoload.php');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->AddAddress($email);
        $mail->Username = "GMAIL USER";
        $mail->Password = "GMAIL PASS";
        $mail->SetFrom('EMAIL', 'ABDO');
        $mail->AddReplyTo("EMAIL", "ABDO");
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }
}

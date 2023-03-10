<?php
session_start();
date_default_timezone_set('Europe/Sofia');

require "../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "115704@students.ue-varna.bg";
$mail->Password = "13071999E";

include 'dbconn.php';
include 'function.php';

error_reporting(E_ERROR | E_PARSE);

// Login
if (isset($_POST['mobile_login'])) {

    $pid = $_POST['pid'];

    $query = "SELECT * FROM users WHERE pid='$pid'";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        while ($rows = mysqli_fetch_array($query_run)) {
            $userId = $rows['id'];

            if (password_verify($_POST['password'], $rows['password'])) {
                $_SESSION['pid'] = $pid;

                $queryy = "UPDATE teams SET status='Yes' WHERE (user1_id='$userId' OR user2_id='$userId') AND delete_team != 'yes'";
                $query_runn = mysqli_query($con, $queryy);

                echo json_encode(['status' => 200]);
                return;
            } else {
                jsonResponse(500, 'Грешна парола');
            }
        }
    } else {
        jsonResponse(500, 'Грешен ПИД');
    }
}

// Logout
if (isset($_POST['action'])) {

    $pid = $_SESSION['pid'];

    $query = "SELECT id, pid FROM users WHERE pid='$pid'";
    $query_run = mysqli_query($con, $query);

    while ($rows = mysqli_fetch_array($query_run)) {
        $userId = $rows['id'];

        $queryy = "UPDATE teams SET status='No' WHERE (user1_id='$userId' OR user2_id='$userId') AND delete_team != 'yes'";
        $query_runn = mysqli_query($con, $queryy);
    }
    unset($_SESSION['pid']);
    jsonResponse(200, 'Успешно излизане');
}

// Update password
if (isset($_POST['mobile_password_update'])) {

    $pid = $_SESSION['pid'];
    $newPassword = $_POST['newPassword'];
    $newPasswordRep = $_POST['passwordRep'];

    if (!$newPassword || !$newPasswordRep) {
        jsonResponse(500, 'Попълнете всички полета');
    } else {
        $query = "SELECT pid, password FROM users WHERE pid='$pid'";
        $query_run = mysqli_query($con, $query);

        while ($rows = mysqli_fetch_array($query_run)) {

            if (password_verify($_POST['oldPassword'], $rows['password'])) {

                if ($newPassword == $newPasswordRep) {
                    $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

                    $queryy = "UPDATE users SET password='$newPassword' WHERE pid='$pid'";
                    $query_runn = mysqli_query($con, $queryy);

                    jsonResponseMain($query_runn, 'Паролата е обновена', 'Паролата не е обновена');
                } else {
                    jsonResponse(500, 'Паролите не съвпадат');
                }
            } else {
                jsonResponse(500, 'Старата паролата е грешна');
            }
        }
    }
}

$time = date('H:i:s');

// Update order status
if (isset($_POST['orderId'])) {

    $id = $_POST['orderId'];
    $ids = explode(" ", $id);

    $query = "SELECT team_id, status FROM orders WHERE team_id='$ids[1]' AND status = 'В процес'";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) < 1) {
        $query = "UPDATE orders SET status = 'В процес', start_time='$time' WHERE id='$ids[0]'";
        $query_run = mysqli_query($con, $query);
        jsonResponseMain($query_run, 'Задачата е стартирана', 'Задачата не е стартирана');
    } else {
        jsonResponse(500, 'Можете да стартирате само 1 задача');
    }
}

// Cancel order
if (isset($_POST['mobile_cancel_order'])) {

    $id = $_POST['id'];
    $text = $_POST['text'];

    if (!$text) {
        jsonResponse(500, 'Попълнете полето');
    } else {
        $query = "UPDATE orders SET status = 'Отказана', cancel_reason = '$text' WHERE id='$id'";
        $query_run = mysqli_query($con, $query);
        jsonResponseMain($query_run, 'Задачата е отказана', 'Задачата не е отказана');
    }
}

// Order step update
if (isset($_POST['step'])) {

    $id = $_POST['id'];
    $step = $_POST['step'];

    $query = "UPDATE orders SET step = '$step' WHERE id='$id'";
    $query_run = mysqli_query($con, $query);
    jsonResponseMain($query_run, 'Задачата е актуализиране', 'Задачата не е актуализиране');
}

// End order
if (isset($_POST['orderEndId'])) {

    $id = $_POST['orderEndId'];

    $queryy = "SELECT * FROM orders WHERE id = '$id'";
    $query_runn = mysqli_query($con, $queryy);

    while ($rows = mysqli_fetch_array($query_runn)) {
        $fullName = $rows["customer_name"];
        $email = $rows["email"];
        $room = $rows["room"];
        $price = $rows["price"];

        $mail->setFrom("carpetserv@gmail.com", "Carpet Services");
        $mail->addAddress($email, $fullName);

        $mail->Subject = "Carpet Services - Услуги";
        $mail->Body = "Вашата заявка за почистване на " . $room . " на стойност " . $price . "лв. е приключена успешно !";

        $mail->send();
    }

    $query = "UPDATE orders SET status = 'Приключена', end_time = '$time' WHERE id='$id'";
    $query_run = mysqli_query($con, $query);
    jsonResponseMain($query_run, 'Задачата е стартирана', 'Задачата не е стартирана');
}

// Remove product from warehouse
if (isset($_POST['productName'])) {

    $name = ($_POST['productName']);
    $teamId = ($_POST['teamId']);

    $query = "SELECT * FROM set_products WHERE quantity > 0 AND product_name = '$name' AND team_id = '$teamId' GROUP BY product_name";
    $query_run = mysqli_query($con, $query);

    while ($rows = mysqli_fetch_array($query_run)) {
        $quantity = $rows['quantity'];
        $id = $rows['id'];
        $finalQuantity = $quantity - 1;

        $query = "UPDATE set_products SET quantity = '$finalQuantity' WHERE id = '$id'";
        mysqli_query($con, $query);

        $queryy = "DELETE FROM set_products WHERE quantity = '0'";
        mysqli_query($con, $queryy);
    }
}

// Return all product from warehouse
if (isset($_POST['productNameReturn'])) {

    $name = ($_POST['productNameReturn']);
    $teamId = ($_POST['teamId']);
    $date = date('Y-m-d');

    $query = "SELECT SUM(quantity) as quantity_sum FROM set_products WHERE product_name = '$name' AND team_id = '$teamId'";
    $query_run = mysqli_query($con, $query);

    while ($rows = mysqli_fetch_array($query_run)) {
        $quantity = $rows['quantity_sum'];

        $query3 = "SELECT * FROM stocks WHERE name = '$name'";
        $query_fulfill = mysqli_query($con, $query3);

        while ($rowss = mysqli_fetch_array($query_fulfill)) {
            $quantityStock = $rowss['quantity'];
            $finalSum = $quantity + $quantityStock;

            $query4 = "UPDATE stocks SET quantity = '$finalSum' WHERE name = '$name'";
            $query_go = mysqli_query($con, $query4);

            $query5 = "DELETE FROM set_products WHERE product_name = '$name' AND team_id = '$teamId'";
            $query_goo = mysqli_query($con, $query5);

            $query = "SELECT name FROM teams WHERE id = '$teamId' AND delete_team != 'yes'";
            $query_run = mysqli_query($con, $query);

            while ($row = mysqli_fetch_array($query_run)) {
                $teamName = $row['name'];

                $query6 = "INSERT INTO seted_product_histories (product_name,quantity,team_id,team_name,date,status) VALUES ('$name','$quantity','$teamId','$teamName','$date','back')";
                $query_runn = mysqli_query($con, $query6);
            }
        }
    }
}

$date = date('Y-m-d H:i:s');

// Product request
if (isset($_POST['mobile_product_request'])) {

    $name = $_POST['product'];
    $quantity = $_POST['quantity'];
    $teamId = $_POST['teamId'];

    if (!$name || !$quantity) {
        jsonResponse(500, 'Попълнете всички полета');
    } else {

        $query = "INSERT INTO product_requests (product_name,quantity,view,date,team_id) VALUES ('$name','$quantity','0','$date','$teamId')";
        $query_run = mysqli_query($con, $query);

        jsonResponseMain($query_run, 'Успешно направена заявка', 'Неуспешно направена заявка');
    }
}

// Ask question
if (isset($_POST['mobile_ask_question'])) {

    $pid = $_POST['pid'];
    $text = $_POST['text'];

    if (!$text) {
        jsonResponse(500, 'Попълнете всички полета');
    } else {

        $query = "INSERT INTO user_questions (user_pid,question,add_date) VALUES ('$pid','$text','$date')";
        $query_run = mysqli_query($con, $query);

        jsonResponseMain($query_run, 'Успешно въпроса е изрпатен за преразглеждане', 'Неуспешно изпращане на въпроса');
    }
}

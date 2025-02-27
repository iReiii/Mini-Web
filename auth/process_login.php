<?php
require "../include/db.php";

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT username, password FROM users WHERE username = :username";
    $query = $conn->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if($user) {
        if($password == $user['password']) {
            session_start();
            $_SESSION['username'] = $user['username'];
            header("Location: ../views/dashboard.php");
            exit;
        } else {
            echo "Password Salah!";
        }
    } else {
        echo "Username Tidak Ditemukan!";
    }
}
?>
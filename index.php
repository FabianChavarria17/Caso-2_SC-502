<?php
session_start();

if (isset($_SESSION["id"])) {
    if ($_SESSION["rol"] == "admin") {
        header("Location: views/administrador.php");
    } else {
        header("Location: views/usuario.php");
    }
    exit();
} else {
    header("Location: views/login.php");
    exit();
}
<?php
// Zobrazení přijaté hodnoty
echo "<h1>Přijatá hodnota</h1>";

// Přijetí přes GET
if (isset($_GET['value'])) {
    echo "Hodnota předaná přes GET: " . htmlspecialchars($_GET['value']) . "<br>";
}

// Přijetí přes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['value'])) {
    echo "Hodnota předaná přes POST: " . htmlspecialchars($_POST['value']) . "<br>";
}

// Přijetí přes SESSION
session_start();
if (isset($_GET['method']) && $_GET['method'] === 'session' && isset($_SESSION['value'])) {
    echo "Hodnota předaná přes SESSION: " . $_SESSION['value'] . "<br>";
}

// Přijetí přes COOKIE
if (isset($_GET['method']) && $_GET['method'] === 'cookie' && isset($_COOKIE['value'])) {
    echo "Hodnota předaná přes COOKIE: " . $_COOKIE['value'] . "<br>";
}
?>

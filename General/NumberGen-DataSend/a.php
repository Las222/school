<?php
// Vygenerujeme náhodné číslo
$randomValue = rand(1, 100);

// Zobrazíme různé odkazy na b.php
echo "<h1>Odkazy na b.php</h1>";

// Předání přes URL (GET)
echo "<a href='b.php?value=$randomValue'>Předání přes GET</a><br>";

// Předání přes formulář (POST)
echo "<form action='b.php' method='post'>
        <input type='hidden' name='value' value='$randomValue'>
        <button type='submit'>Předání přes POST</button>
      </form>";

// Předání přes SESSION
session_start();
$_SESSION['value'] = $randomValue;
echo "<a href='b.php?method=session'>Předání přes SESSION</a><br>";

// Předání přes COOKIE
setcookie('value', $randomValue, time() + 3600, "/");
echo "<a href='b.php?method=cookie'>Předání přes COOKIE</a><br>";
?>

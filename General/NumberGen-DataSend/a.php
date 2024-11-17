<?php
session_start(); // Zahájení sessionu :p

// Generace jedné náhodné hodnoty o.o
$randomValue = rand(1, 100);

// Uložení náhodné hodnoty do SESSION a COOKIE (sušenky :3) pro pozdější přístup
$_SESSION['value'] = $randomValue;
setcookie("value", $randomValue, time() + 3600); // Platnost 1 hodinu TwT
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Předání hodnoty</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }
        h1 {
            color: #444;
        }
        .link-container {
            margin-top: 20px;
        }
        a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 5px;
            font-size: 16px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Předávání hodnoty do b.php</h1>
    <p>Vygenerovaná hodnota: <strong><?php echo $randomValue; ?></strong></p>
    <div class="link-container">
        <a href="b.php?value=<?php echo $randomValue; ?>">Přenos přes GET</a>
        <a href="b.php?method=session">Přenos přes SESSION</a>
        <a href="b.php?method=cookie">Přenos přes COOKIE</a>
        <form action="b.php" method="post" style="display: inline;">
            <input type="hidden" name="value" value="<?php echo $randomValue; ?>">
            <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Přenos přes POST</button>
        </form>
    </div>
</body>
</html>

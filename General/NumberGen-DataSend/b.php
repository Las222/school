<?php
session_start(); // Zahájení sessionu :p

// Funkce pro přidání hodnoty do historie :3
function addToHistory($value, $method) {
    if (!isset($_SESSION['history']) || !is_array($_SESSION['history'])) {
        $_SESSION['history'] = []; // Zavedení historie, pokud není :o
    }
    $_SESSION['history'][] = [
        'value' => $value,
        'method' => $method
    ];
}

// Zjištění hodnoty a způsobu přenosu :D
if (isset($_GET['value'])) {
    $receivedValue = htmlspecialchars($_GET['value']);
    $method = 'GET';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['value'])) {
    $receivedValue = htmlspecialchars($_POST['value']);
    $method = 'POST';
} elseif (isset($_GET['method']) && $_GET['method'] === 'session' && isset($_SESSION['value'])) {
    $receivedValue = $_SESSION['value'];
    $method = 'SESSION';
} elseif (isset($_GET['method']) && $_GET['method'] === 'cookie' && isset($_COOKIE['value'])) {
    $receivedValue = $_COOKIE['value'];
    $method = 'COOKIE';
} else {
    $receivedValue = null;
    $method = null;
}

// Přidání hodnoty do historie, pokud je k dispozici O.O
if ($receivedValue !== null && $method !== null) {
    addToHistory($receivedValue, $method);
}

// Vymazání historie na uživatelskou žádost B)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_history'])) {
    unset($_SESSION['history']);
    $message = "Historie byla úspěšně vymazána.";
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uložené hodnoty</title>
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
        .history {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #fff;
            text-align: left;
            display: inline-block;
        }
        a, button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button {
            background-color: #28a745;
        }
        .clear-btn {
            background-color: #dc3545;
        }
        a:hover, button:hover {
            background-color: #0056b3;
        }
        .clear-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h1>Uložené hodnoty</h1>
    <div class="history">
        <?php
        if (!empty($_SESSION['history'])) {
            foreach ($_SESSION['history'] as $index => $entry) {
                echo "Hodnota " . ($index + 1) . ": " . htmlspecialchars($entry['value']) . " (" . htmlspecialchars($entry['method']) . ")<br>";
            }
        } else {
            echo "Zatím žádné hodnoty nejsou uložené.";
        }
        ?>
    </div>
    <br>
    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post" style="margin-top: 20px;">
        <button type="submit" name="clear_history" class="clear-btn">Vymazat historii</button>
    </form>
    <br>
    <a href="a.php"><button>Vrátit se na a.php</button></a>
</body>
</html>

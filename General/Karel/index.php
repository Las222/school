<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karel - PHP</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #333; color: #fff; margin: 0; padding: 0; }
        #main { display: flex; justify-content: center; align-items: flex-start; margin: 20px; }
        #controls { margin-right: 20px; }
        #commands { width: 300px; height: 200px; }
        #instructions { background-color: #444; padding: 10px; border-radius: 5px; }
        h1 { text-align: center; }
        #karel { display: grid; grid-template-columns: repeat(10, 40px); grid-template-rows: repeat(10, 40px); margin: 20px auto; gap: 1px; }
        .cell { width: 40px; height: 40px; background-color: #444; display: flex; align-items: center; justify-content: center; color: #fff; position: relative; }
        .karel { position: absolute; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-weight: bold; z-index: 1; }
        .marker { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; }
    </style>
</head>
<body>
    <h1>Karel</h1>
    <div id="main">
        <div id="controls">
            <form method="POST" action="index.php">
                <textarea id="commands" name="commands" placeholder="Zadejte příkazy..."><?php echo htmlspecialchars($_POST['commands'] ?? ''); ?></textarea>
                <button type="submit">Proveď</button>
            </form>
        </div>
        <div id="instructions">
            <h3>Možné příkazy:</h3>
            <ul>
                <li><strong>KROK [X]</strong> - Posune Karla o X kroků ve směru natočení.</li>
                <li><strong>VLEVOBOK [X]</strong> - Otočí Karla doleva X-krát na místě.</li>
                <li><strong>VPRAVOBOK [X]</strong> - Otočí Karla doprava X-krát na místě.</li>
                <li><strong>POLOZ [barva]</strong> - Položí na aktuální pozici Karla čtvereček s barvou.</li>
                <li><strong>RESET</strong> - Vyčistí pole a nastaví Karla na počáteční pozici.</li>
            </ul>
        </div>
    </div>
    <div id="karel">
        <?php
        $gridSize = 10;
        $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, ['marker' => '', 'karel' => false]));
        $karelPos = ['x' => 0, 'y' => 0];
        $karelDir = 0;

        function getKarelSymbol($dir) {
            return ['→', '↓', '←', '↑'][$dir];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commands = explode("\n", strtoupper(trim($_POST['commands'] ?? '')));
            foreach ($commands as $command) {
                $parts = preg_split('/\s+/', trim($command));
                $cmd = $parts[0] ?? '';
                $param = intval($parts[1] ?? 1);

                switch ($cmd) {
                    case 'KROK':
                        for ($i = 0; $i < $param; $i++) {
                            switch ($karelDir) {
                                case 0: if ($karelPos['x'] < $gridSize - 1) $karelPos['x']++; break;
                                case 1: if ($karelPos['y'] < $gridSize - 1) $karelPos['y']++; break;
                                case 2: if ($karelPos['x'] > 0) $karelPos['x']--; break;
                                case 3: if ($karelPos['y'] > 0) $karelPos['y']--; break;
                            }
                        }
                        break;

                    case 'VLEVOBOK':
                        $karelDir = ($karelDir + $param) % 4;
                        break;

                    case 'VPRAVOBOK':
                        $karelDir = ($karelDir - $param + 4) % 4;
                        break;

                    case 'POLOZ':
                        $color = strtolower($parts[1] ?? 'white');
                        $grid[$karelPos['y']][$karelPos['x']]['marker'] = $color;
                        break;

                    case 'RESET':
                        $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, ['marker' => '', 'karel' => false]));
                        $karelPos = ['x' => 0, 'y' => 0];
                        $karelDir = 0;
                        break;
                }
            }
        }

        $grid[$karelPos['y']][$karelPos['x']]['karel'] = true;

        foreach ($grid as $row) {
            foreach ($row as $cell) {
                $markerStyle = $cell['marker'] ? "background-color: {$cell['marker']};" : '';
                $karelSymbol = $cell['karel'] ? getKarelSymbol($karelDir) : '';
                echo "<div class='cell' style='{$markerStyle}'>
                        <div class='marker'></div>
                        <div class='karel'>{$karelSymbol}</div>
                      </div>";
            }
        }
        ?>
    </div>
</body>
</html>

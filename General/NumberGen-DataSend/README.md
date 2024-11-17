# Úkol: Posílání hodnot mezi skripty

## Způsoby předávání hodnoty
1. **GET (parametr v URL)**
   - Hodnota je přidána do URL jako query string (`?value=...`).
   - Snadné použití, hodí se pro jednoduché přenosy.
   - Ukázka: `<a href='b.php?value=$randomValue'>Předání přes GET</a>`

2. **POST (formulář)**
   - Hodnota je odeslána jako součást těla HTTP požadavku.
   - Bezpečnější než GET, není vidět v URL.
   - Ukázka: `<form action='b.php' method='post'>...`

3. **SESSION**
   - Hodnota je uložená na straně serveru a přístupná z libovolné stránky během relace.
   - Vhodné pro uchování dat mezi stránkami bez potřeby je předávat přímo.
   - Ukázka: `$_SESSION['value'] = $randomValue;`

4. **COOKIE**
   - Hodnota je uložená u uživatele v prohlížeči a posílána při každém požadavku na server.
   - Vhodné pro uchování dat na delší dobu.
   - Ukázka: `setcookie('value', $randomValue, time() + 3600, "/");`

## Jak to spustit
1. Nahrajte oba soubory na webový server.
2. Otevřete `a.php` v prohlížeči.
3. Klikněte na různé odkazy a podívejte se, jak se hodnota zobrazuje na `b.php`.

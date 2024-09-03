**Co má žák udělat:**
Úkolem bude analyzovat databázi tržních dat, která obsahuje informace o prodeji ovoce a zeleniny. Žák bude muset formulovat SQL dotazy k vyřešení specifických úkolů.

---------------------------------------------------------------------------------------------------------------------------------------------------

**Podmínky zadání:**
1. Dostupná bude databáze s názvem `trziste.db`, která obsahuje tabulky `ovoce` a `zelenina` se specifickými atributy.
2. Každá tabulka má identifikátor položky, název, množství a cenu.

---------------------------------------------------------------------------------------------------------------------------------------------------

**Postup:**
1. Otevři databázi `trziste.db` ve svém SQL editoru.
2. Zformuluj SQL dotazy pro splnění úkolů uvedených níže.
3. Pro každý dotaz zapiš odpověď a případně zdůvodnění v textovém souboru.

---------------------------------------------------------------------------------------------------------------------------------------------------

**Otázky:**
1. Jaký je celkový obrat za prodej ovoce a zeleniny?
   - SQL dotaz: `SELECT SUM(mnozstvi * cena) AS obrat FROM ovoce UNION ALL SELECT SUM(mnozstvi * cena) AS obrat FROM zelenina;`

	Odpověď:
```
Pro výpočet celkového obratu za prodej ovoce a zeleniny musíme sečíst všechny prodeje ovoce a zeleniny. To provedeme pomocí SQL dotazu:
SELECT SUM(mnozstvi * cena) AS obrat FROM ovoce UNION ALL SELECT SUM(mnozstvi * cena) AS obrat FROM zelenina;
```


3. Které ovoce se prodávalo nejčastěji?
   - SQL dotaz: `SELECT nazev, SUM(mnozstvi) AS celkove_mnozstvi FROM ovoce GROUP BY nazev ORDER BY celkove_mnozstvi DESC LIMIT 1;`
	Odpověď:
```
Pro zjištění nejprodávanějšího ovoce potřebujeme spočítat, které ovoce bylo celkově prodáno nejvíce. SQL dotaz k tomu vypadá takto:
SELECT nazev, SUM(mnozstvi) AS celkove_mnozstvi FROM ovoce GROUP BY nazev ORDER BY celkove_mnozstvi DESC LIMIT 1;
```


4. Kolik různých druhů zeleniny se prodávalo za poslední měsíc?
   - SQL dotaz: `SELECT COUNT(DISTINCT nazev) AS pocet_druhu_zeleniny FROM zelenina WHERE datum >= DATE('now', '-1 month');`
	Odpověď:
```
 Chceme zjistit počet různých druhů zeleniny, které byly prodávány za poslední měsíc. To provedeme pomocí SQL dotazu:
 SELECT COUNT(DISTINCT nazev) AS pocet_druhu_zeleniny FROM zelenina WHERE datum >= DATE('now', '-1 month');
```


5. Jaká byla průměrná cena za kilogram ovoce za poslední tři měsíce?
   - SQL dotaz: `SELECT AVG(cena) AS prumerna_cena_za_kg FROM ovoce WHERE datum >= DATE('now', '-3 month');`
	Odpověď:
```
 Průměrná cena za kilogram ovoce za poslední tři měsíce se dá získat pomocí následujícího SQL dotazu:
 SELECT AVG(cena) AS prumerna_cena_za_kg FROM ovoce WHERE datum >= DATE('now', '-3 month');
```


6. Který zákazník utratil nejvíce peněz za nákup ovoce a zeleniny?
   - SQL dotaz: 
     ```
     SELECT zakaznik, SUM(mnozstvi * cena) AS celkova_utrata 
     FROM (SELECT zakaznik, mnozstvi, cena FROM ovoce UNION ALL SELECT zakaznik, mnozstvi, cena FROM zelenina) AS obchod 
     GROUP BY zakaznik 
     ORDER BY celkova_utrata DESC LIMIT 1;
     ```
	Odpověď:
```
 Jméno zákazníka s největší utratou za nákup ovoce a zeleniny se dá zjistit pomocí následujícího SQL dotazu:
 SELECT zakaznik, SUM(mnozstvi * cena) AS celkova_utrata 
FROM (SELECT zakaznik, mnozstvi, cena FROM ovoce UNION ALL SELECT zakaznik, mnozstvi, cena FROM zelenina) AS obchod 
GROUP BY zakaznik 
ORDER BY celkova_utrata DESC LIMIT 1;
```

---------------------------------------------------------------------------------------------------------------------------------------------------

**Code**
 ```
-- Vytvoření tabulky pro prodej ovoce
CREATE TABLE ovoce (
    id INTEGER PRIMARY KEY,
    nazev TEXT NOT NULL,
    mnozstvi REAL NOT NULL,
    cena REAL NOT NULL,
    datum DATE NOT NULL,
    zakaznik TEXT NOT NULL
);

-- Vytvoření tabulky pro prodej zeleniny
CREATE TABLE zelenina (
    id INTEGER PRIMARY KEY,
    nazev TEXT NOT NULL,
    mnozstvi REAL NOT NULL,
    cena REAL NOT NULL,
    datum DATE NOT NULL,
    zakaznik TEXT NOT NULL
);

-- Příklad vložení dat do tabulky ovoce
INSERT INTO ovoce (nazev, mnozstvi, cena, datum, zakaznik) VALUES
('Jablka', 10, 30, '2024-04-01', 'Jan Novák'),
('Banány', 15, 25, '2024-04-02', 'Eva Kovářová'),
('Pomeranče', 20, 20, '2024-04-03', 'Pavel Dvořák');

-- Příklad vložení dat do tabulky zelenina
INSERT INTO zelenina (nazev, mnozstvi, cena, datum, zakaznik) VALUES
('Rajčata', 5, 40, '2024-04-01', 'Jan Novák'),
('Okurky', 8, 35, '2024-04-02', 'Eva Kovářová'),
('Cibule', 10, 15, '2024-04-03', 'Pavel Dvořák');

 ```

---------------------------------------------------------------------------------------------------------------------------------------------------

**Výstup:**
Tvým výstupem bude textový soubor obsahující odpovědi na všechny otázky. Každá odpověď bude doprovázena SQL dotazem, který jsi použil, a samotnou odpovědí.

# 2. kodutoo (I rühm)

## Kirjeldus

1. Võimalda oma lehel kasutajat luua ja kontrollida sisselogimist (kui on õige trüki kasutaja id )
  * Abi saad 4. tunnitööst
1. OLULILINE! ÄRA POSTITA GITHUBI GREENY MYSQL PAROOLE. Selleks toimi järgmiselt:
  * loo eraldi fail `config.php` ja lisa sinna kasutaja ja parool
  ```PHP
  $servername = "localhost";
  $username = "username";
  $password = "password";
  ```
  * kasuta [gitignore'i] (https://help.github.com/articles/ignoring-files/), et seda faili mitte sünkroniseerida lisa `.gitignore` nimeline fail ja sinna lisa
  ```
  config.php
  ```
  * Andmebaasi nimi lisa aga kindlasti enda faili, siis saan kodust tööd kontrollida
  ```PHP
  $database = "database";

  $mysqli = new mysqli($servername, $username, $password, $database);

  ```

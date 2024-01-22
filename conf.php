<?php
//AB kasutaja, serverrinimi, salasõna, AB nimi -> ühendame seda andtud väärtusega, lisame tähte koodering
$kasutaja = 'Teacher';
$serverinimi = 'localhost';
$parool = '123123';
$andmebaas = 'webworks';
$yhendus = new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus -> set_charset('UTF8');
?>
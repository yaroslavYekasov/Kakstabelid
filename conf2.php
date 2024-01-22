<?php
$kasutaja='d123188_yaroslav';
$serverinimi='d123188.mysql.zonevs.eu';
$parool='P5a6y5e6r.';
$andmebaas='d123188_phptood';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');
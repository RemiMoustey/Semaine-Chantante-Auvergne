<?php
header('Content-Type: text/csv;');
header('Content-Disposition: attachment; filename="choristes.csv"'); 
$data = $users->fetchAll();
    
foreach($data as $d)
{
    echo utf8_decode("\"{$d['surname']}\";\"{$d['firstname']}\";\"{$d['user_address']}\";\"{$d['postal_code']} - {$d['town']}\";\"{$d['phone_number']}\";\"{$d['phone_number_office']}\";\"{$d['music_stand']}\";\"{$d['email']}\";\"{$d['paid']}\";") . "\n";
}
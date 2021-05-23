<?php 
/*Ricerca le notizie,non verifica che l'utente sia loggato perchè questa funzione è aperta a tutti gli utenti*/
/* Key e endpoint */
$key = 'c7d8115b-cd40-493e-96a8-bf196eefb21d';
$endpoint = 'https://content.guardianapis.com/search?q=';
/**********************/

$news_argument=$_POST['search'];
$query=$endpoint.$news_argument.'&api-key='.$key;
$curl=curl_init();
curl_setopt($curl,CURLOPT_URL,$query);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
$result=curl_exec($curl);
curl_close($curl);
echo($result);
exit;
?>
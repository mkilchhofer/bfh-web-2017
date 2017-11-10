<?php
require_once 'gear.php';
header( "refresh:2;url=/?s=my" );

$userId = $_COOKIE['userId'];

Gear::addGear($_POST['name'],$userId,$_POST['purchasePrice'],$_POST['purchaseDate'],$_POST['purchasedPlace'],'','');

echo "added, redirecting in 2 seconds...";

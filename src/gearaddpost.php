<?php
include "authentication.inc.php";
require_once 'GearDbHandler.php';
require_once 'Gear.php';

$userId = $_SESSION['userId'];

$gear = new Gear(null, $_POST['name'], $userId, $_POST['purchasePrice'], $_POST['purchaseDate'], $_POST['purchasedPlace']);

$result = GearDbHandler::addGear($gear);

if ($result) {
    echo "added, <a href=\"/?s=my\">Go to My Gear</a>";
} else {
    echo "not added, <a href=\"javascript:history.back()\">Go Back</a>";
}
/*
if ($result) {
    include_once 'upload.php';
}
*/

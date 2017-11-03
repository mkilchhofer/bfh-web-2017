<?php


class Gear {

    static public function getProducts($owner) {
        require_once "db.inc.php";
        $result = $db->query("SELECT * FROM GearItem;");

        $productsByOwner = array();

        while ($gearItem = $result->fetch_assoc()) {
            if($gearItem['currentOwnerId']==$owner){
                $productsByOwner[]=$gearItem;
            }
        }

        $result->close();
        $db->close();

        return $productsByOwner;
    }

    static public function getProduct($itemId) {
        require_once "db.inc.php";
        $result = $db->query("SELECT * FROM GearItem WHERE gearItemId = $itemId;");

        $gearItem = $result->fetch_assoc();
        $result->close();
        $db->close();

        return $gearItem;
    }
}

<?php
require_once 'db.inc.php';


class Gear
{

    static public function getGearByOwner($ownerId)
    {
        $id = (int)$ownerId;
        $sql_query = "SELECT * FROM GearItem WHERE currentOwnerId = $id;";
        $result = DB::doQuery($sql_query);

        $gearItems = array();
        if (!$result) {
            return null;
        }

        while ($gearItem = $result->fetch_assoc()) {
            $gearItems[] = $gearItem;
        }

        return $gearItems;
    }

    static public function getGear($itemId)
    {
        $id = (int)$itemId;
        $sql_query = "SELECT * FROM GearItem WHERE gearItemId = $id;";
        $result = DB::doQuery($sql_query);

        $gearItem = $result->fetch_assoc();

        return $gearItem;
    }

    static public function addGear($name, $currentOwnerId, $purchasePrice, $purchaseDate, $purchasePlace, $receiptImageId, $picture)
    {
        $sql_query = "INSERT INTO `GearItem` (`gearItemId`, `name`, `currentOwnerId`,
                                              `purchasePrice`, `purchaseDate`, `purchasePlace`,
                                              `receiptImageId`, `picture`)
                                              VALUES
                                              (NULL, '$name', '$currentOwnerId', '$purchasePrice'
                                              '$purchaseDate', '$purchasePlace', '$receiptImageId', '$picture');";
        $result = DB::doQuery($sql_query);
        var_dump($result);
    }
}

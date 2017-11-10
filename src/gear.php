<?php
require_once 'db.inc.php';


class Gear
{

    static public function getGearByOwner($ownerId)
    {
        $id = (int)$ownerId;
        $sql_query = "SELECT * FROM GearItem WHERE CurrentOwnerId = $id;";
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

    static public function getGearById($itemId)
    {
        $id = (int)$itemId;
        $sql_query = "SELECT * FROM GearItem WHERE GearId = $id;";
        $result = DB::doQuery($sql_query);

        $gearItem = $result->fetch_assoc();

        return $gearItem;
    }

    static public function addGear($name, $currentOwnerId, $purchasePrice, $purchaseDate, $purchasePlace)
    {
        $sql_query = "INSERT INTO `GearItem` (`GearId`, `GearName`, `CurrentOwnerId`,
                                              `PurchasePrice`, `PurchaseDate`, `PurchasePlace`)
                                              VALUES
                                              (NULL, '$name', '$currentOwnerId', '$purchasePrice',
                                              '$purchaseDate', '$purchasePlace');";
        $result = DB::doQuery($sql_query);

        return $result;
    }
}

<?php
require_once 'core/db.inc.php';

class Gear {
    public $id, $name, $currentOwnerId, $purchasePrice, $purchaseDate, $purchasePlace;

    function __construct($id, $name, $currentOwnerId, $purchasePrice, $purchaseDate, $purchasePlace) {
        $this->id = $id;
        $this->name = $name;
        $this->currentOwnerId = $currentOwnerId;
        $this->purchasePrice = $purchasePrice;
        $this->purchaseDate = $purchaseDate;
        $this->purchasePlace = $purchasePlace;
    }
}

class GearModel
{

    static public function getGearByOwner($ownerId)
    {
        $id = (int)$ownerId;
        $sql_query = "SELECT * FROM GearItem WHERE CurrentOwnerId = $id;";
        $result = DB::doQuery($sql_query);

        if (!$result) {
            return null;
        }
        $gearItems = array();

        while ($gearItem = $result->fetch_assoc()) {

            $gear = new Gear(
                $gearItem['GearId'],
                $gearItem['GearName'],
                $gearItem['CurrentOwnerId'],
                $gearItem['PurchasePrice'],
                $gearItem['PurchaseDate'],
                $gearItem['PurchasePlace']
            );


            $gearItems[] = $gear;
        }


        return $gearItems;
    }

    static public function getGearById($itemId)
    {
        $id = (int)$itemId;
        $sql_query = "SELECT * FROM GearItem WHERE GearId = $id;";
        $result = DB::doQuery($sql_query);

        if (!$result) {
            return null;
        }
        $gearItem = $result->fetch_assoc();

        $gear = new Gear(
            $gearItem['GearId'],
            $gearItem['GearName'],
            $gearItem['CurrentOwnerId'],
            $gearItem['PurchasePrice'],
            $gearItem['PurchaseDate'],
            $gearItem['PurchasePlace']
        );

        return $gear;
    }

    static public function addGear(Gear $gear)
    {
        $sql_query = "INSERT INTO `GearItem` (`GearId`, `GearName`, `CurrentOwnerId`,
                                              `PurchasePrice`, `PurchaseDate`, `PurchasePlace`)
                                              VALUES
                                              (NULL, '$gear->name', '$gear->currentOwnerId', '$gear->purchasePrice',
                                              '$gear->purchaseDate', '$gear->purchasePlace');";
        $result = DB::doQuery($sql_query);

        return $result;
    }


}

<?php
require_once 'core/db.inc.php';

class Gear {
    public $id, $name, $currentOwnerId, $categoryId, $purchasePrice, $purchaseDate, $purchasePlace;

    function __construct($id, $name, $currentOwnerId, $categoryId, $purchasePrice, $purchaseDate, $purchasePlace) {
        $this->id = $id;
        $this->name = $name;
        $this->currentOwnerId = $currentOwnerId;
        $this->categoryId = $categoryId;
        $this->purchasePrice = $purchasePrice;
        $this->purchaseDate = $purchaseDate;
        $this->purchasePlace = $purchasePlace;
    }
}

class GearModel
{

    static public function getGearByOwner($ownerId)
    {
        //$sql_query = "SELECT * FROM GearItem WHERE CurrentOwnerId = ?";
        global $language;
        $sql_query = "SELECT
            GearItem.GearId,
            GearItem.GearName,
            GearItem.CurrentOwnerId,
            GearItem.PurchasePrice,
            GearItem.PurchaseDate,
            GearItem.PurchasePlace,
            CategoryTranslations.CategoryDescription
        FROM GearItem
        INNER JOIN CategoryTranslations ON GearItem.CategoryId = CategoryTranslations.CategoryId
        WHERE CurrentOwnerId = ?
        AND CategoryTranslations.Language = ?";


        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('is', $ownerId, $language);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            return null;
        }
        $gearItems = array();

        while ($gearItem = $result->fetch_assoc()) {

            $gear = new Gear(
                $gearItem['GearId'],
                $gearItem['GearName'],
                $gearItem['CurrentOwnerId'],
                $gearItem['CategoryDescription'],
                $gearItem['PurchasePrice'],
                $gearItem['PurchaseDate'],
                $gearItem['PurchasePlace']
            );


            $gearItems[] = $gear;
        }


        return $gearItems;
    }

    static public function getGearById($ownerId, $itemId)
    {
        //$sql_query = "SELECT * FROM GearItem WHERE GearId = ?";
        global $language;
        $sql_query = "SELECT
            GearItem.GearId,
            GearItem.GearName,
            GearItem.CurrentOwnerId,
            GearItem.PurchasePrice,
            GearItem.PurchaseDate,
            GearItem.PurchasePlace,
            CategoryTranslations.CategoryDescription
        FROM GearItem
        INNER JOIN CategoryTranslations ON GearItem.CategoryId = CategoryTranslations.CategoryId
        WHERE GearId = ?
        AND CategoryTranslations.Language = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('is', $itemId, $language);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            return null;
        }
        $gearItem = $result->fetch_assoc();

        $gear = new Gear(
            $gearItem['GearId'],
            $gearItem['GearName'],
            $gearItem['CurrentOwnerId'],
            $gearItem['CategoryDescription'],
            $gearItem['PurchasePrice'],
            $gearItem['PurchaseDate'],
            $gearItem['PurchasePlace']
        );

        if ($gear->currentOwnerId != $ownerId){
            return null;
        }

        return $gear;
    }

    static public function addGear(Gear $gear)
    {
        $sql_query = "INSERT INTO `GearItem` (`GearName`, `CurrentOwnerId`, `CategoryId`,
                                              `PurchasePrice`, `PurchaseDate`, `PurchasePlace`)
                                              VALUES
                                              ('$gear->name', '$gear->currentOwnerId','$gear->categoryId', '$gear->purchasePrice',
                                              '$gear->purchaseDate', '$gear->purchasePlace');";
        $result = DB::doQuery($sql_query);

        return $result;
    }

    static public function getSales()
    {
        $current_date = date("Y-m-d H:i:s");
        $sql_query = "SELECT
            Sale.SaleId,
            Sale.SalesPrice,
            GearItem.GearName,
            User.UserName
        FROM Sale
        INNER JOIN GearItem ON Sale.GearId = GearItem.GearId
        INNER JOIN User ON GearItem.CurrentOwnerId = User.UserId
        WHERE Sale.SalesStart <= '$current_date' and Sale.SalesEnd >= '$current_date'";
        $result = DB::doQuery($sql_query);

        if (!$result) {
            return null;
        }
        $salesItems = array();

        while ($salesItem = $result->fetch_assoc()) {
            $salesItems[] = $salesItem;
        }

        return $salesItems;
    }
    static public function getCategories()
    {
        global $language;

        $sql_query = "SELECT
            Category.CategoryId,
            CategoryTranslations.CategoryDescription
        FROM Category
        INNER JOIN CategoryTranslations ON Category.CategoryId = CategoryTranslations.CategoryId
        WHERE CategoryTranslations.Language = '$language'";
        $result = DB::doQuery($sql_query);

        if (!$result) {
            return null;
        }
        $categories = array();

        while ($salesItem = $result->fetch_assoc()) {
            $categories[] = $salesItem;
        }

        return $categories;
    }

    static public function getSaleById($saleId)
    {
        $sql_query = "SELECT
            Sale.SaleId,
            Sale.SalesPrice,
            Sale.SalesStart,
            Sale.SalesEnd,
            GearItem.GearName,
            User.UserName
        FROM Sale
        INNER JOIN GearItem ON Sale.GearId = GearItem.GearId
        INNER JOIN User ON GearItem.CurrentOwnerId = User.UserId
        WHERE Sale.SaleId = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $saleId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            return null;
        }

        $salesItem = $result->fetch_assoc();

        return $salesItem;
    }
}

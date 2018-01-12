<?php
require_once 'core/db.inc.php';
require_once 'model.php';

class Gear extends EntityBase {
    public $name,
        $currentOwnerId,
        $categoryId,
        $categoryDescription,
        $purchasePrice,
        $purchaseDate,
        $purchasePlace,
        $warranty;
}

class Category extends EntityBase {
    public $title;
}

class GearModel
{

    public static function getGearByOwner($userId)
    {
        global $language;
        $sql_query = "SELECT
            GearItem.id,
            GearItem.name,
            GearItem.currentOwnerId,
            GearItem.purchasePrice,
            GearItem.purchaseDate,
            GearItem.purchasePlace,
            GearItem.warranty,
            Category.title_$language AS CategoryDescription
        FROM GearItem
        INNER JOIN Category ON GearItem.categoryId = Category.id
        WHERE GearItem.currentOwnerId = ?
        ORDER BY purchaseDate DESC";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_gearName, $row_currentOwnerId, $row_purchasePrice, $row_purchaseDate, $row_purchasePlace, $row_warranty, $row_categoryDescription);
        $result = array();
        while ($stmt->fetch()) {
            $gear = new Gear();
            $gear->id = strip_tags($row_id);
            $gear->name = strip_tags($row_gearName);
            $gear->currentOwnerId = strip_tags($row_currentOwnerId);
            $gear->categoryDescription = strip_tags($row_categoryDescription);
            $gear->purchasePrice = strip_tags($row_purchasePrice);
            $gear->purchaseDate = strip_tags($row_purchaseDate);
            $gear->purchasePlace = strip_tags($row_purchasePlace);
            $gear->warranty = strip_tags($row_warranty);

            $result[] = $gear;
        }

        return $result;
    }

    public static function getGearById($userId, $itemId)
    {
        global $language;
        $sql_query = "SELECT
            GearItem.id,
            GearItem.name,
            GearItem.currentOwnerId,
            GearItem.purchasePrice,
            GearItem.purchaseDate,
            GearItem.purchasePlace,
            GearItem.warranty,
            Category.id,
            Category.title_$language AS CategoryDescription
        FROM GearItem
        INNER JOIN Category ON GearItem.categoryId = Category.id
        WHERE GearItem.id = ? AND GearItem.currentOwnerId = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('ii', $itemId, $userId);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_gearName, $row_currentOwnerId, $row_purchasePrice, $row_purchaseDate, $row_purchasePlace, $row_warranty, $row_categoryId, $row_categoryDescription);

        $gear = null;
        while ($stmt->fetch()) {
            $gear = new Gear();
            $gear->id = strip_tags($row_id);
            $gear->name = strip_tags($row_gearName);
            $gear->currentOwnerId = strip_tags($row_currentOwnerId);
            $gear->categoryId = strip_tags($row_categoryId);
            $gear->categoryDescription = strip_tags($row_categoryDescription);
            $gear->purchasePrice = strip_tags($row_purchasePrice);
            $gear->purchaseDate = strip_tags($row_purchaseDate);
            $gear->purchasePlace = strip_tags($row_purchasePlace);
            $gear->warranty = strip_tags($row_warranty);
        }

        return $gear;
    }

    public static function deleteGearById($userId, $itemId)
    {
        global $language;
        $sql_query = "DELETE
        FROM GearItem
        WHERE id = ? AND currentOwnerId = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('ii', $itemId, $userId);
        return $stmt->execute();
    }

    public static function addGear($userId, Gear $gear)
    {
        if($userId != $gear->currentOwnerId){
            return false;
        }

        $sql_query = "INSERT INTO `GearItem` (
            `name`,
            `currentOwnerId`,
            `categoryId`,
            `purchasePrice`,
            `purchaseDate`,
            `purchasePlace`,
            warranty)
        VALUES (?,?,?,?,?,?,?)";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('siidsss',
            $gear->name,
            $gear->currentOwnerId,
            $gear->categoryId,
            $gear->purchasePrice,
            $gear->purchaseDate,
            $gear->purchasePlace,
            $gear->warranty);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public static function updateGear(Gear $gear)
    {
        $sql_query = 'UPDATE GearItem SET
            name = ?,
            categoryId = ?,
            purchasePrice = ?,
            purchaseDate = ?,
            purchasePlace = ?,
            warranty = ?
          WHERE GearItem.id = ?';

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('sidsssi',
            $gear->name,
            $gear->categoryId,
            $gear->purchasePrice,
            $gear->purchaseDate,
            $gear->purchasePlace,
            $gear->warranty,
            $gear->id);

        return $stmt->execute();
    }

    public static function getCategories()
    {
        global $language;

        $sql_query = "SELECT
            Category.id,
            Category.title_$language
        FROM Category";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_title);
        $result = array();
        while ($stmt->fetch()) {
            $category = new Category();
            $category->id = $row_id;
            $category->title = $row_title;

            $result[] = $category;
        }

        return $result;
    }
}

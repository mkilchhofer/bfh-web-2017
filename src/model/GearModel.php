<?php
require_once 'core/db.inc.php';
require_once 'model.php';

class Gear extends EntityBase {
    public $name,
        $currentOwnerId,
        $category,
        $purchasePrice,
        $purchaseDate,
        $purchasePlace,
        $receiptIds,
        $pictureIds;
}

class Category extends EntityBase {
    public $title;
}

class Attachment extends EntityBase {
    public $description,
        $data,
        $type;
}

class GearModel
{

    static public function getGearByOwner($ownerId)
    {
        global $language;
        $sql_query = "SELECT
            GearItem.GearId,
            GearItem.GearName,
            GearItem.CurrentOwnerId,
            GearItem.PurchasePrice,
            GearItem.PurchaseDate,
            GearItem.PurchasePlace,
            Category.Title_$language AS CategoryDescription
        FROM GearItem
        INNER JOIN Category ON GearItem.CategoryId = Category.CategoryId
        WHERE CurrentOwnerId = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $ownerId);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_gearName, $row_currentOwnerId, $row_purchasePrice, $row_purchaseDate, $row_purchasePlace, $row_category);
        $result = array();
        while ($stmt->fetch()) {
            $gear = new Gear();
            $gear->id = $row_id;
            $gear->name = $row_gearName;
            $gear->currentOwnerId = $row_currentOwnerId;
            $gear->category = $row_category;
            $gear->purchasePrice = $row_purchasePrice;
            $gear->purchaseDate = $row_purchaseDate;
            $gear->purchasePlace = $row_purchasePlace;

            $result[] = $gear;
        }

        return $result;
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
            Category.Title_$language AS CategoryDescription
        FROM GearItem
        INNER JOIN Category ON GearItem.CategoryId = Category.CategoryId
        WHERE GearId = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $itemId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            return null;
        }
        $gearItem = $result->fetch_assoc();

        $gear = new Gear();
        $gear->id = $gearItem['GearId'];
        $gear->name = $gearItem['GearName'];
        $gear->currentOwnerId = $gearItem['CurrentOwnerId'];
        $gear->category = $gearItem['CategoryDescription'];
        $gear->purchasePrice = $gearItem['PurchasePrice'];
        $gear->purchaseDate = $gearItem['PurchaseDate'];
        $gear->purchasePlace = $gearItem['PurchasePlace'];
        $gear->receiptIds = self::getAttachmentDetailsByGearId('Receipt', $itemId);
        $gear->pictureIds = self::getAttachmentDetailsByGearId('Picture', $itemId);

        if ($gear->currentOwnerId != $ownerId){
            return null;
        }

        return $gear;
    }

    static public function addGear(Gear $gear)
    {
        $sql_query = "INSERT INTO `GearItem` (
            `GearName`,
            `CurrentOwnerId`,
            `CategoryId`,
            `PurchasePrice`,
            `PurchaseDate`,
            `PurchasePlace`)
        VALUES (
            '$gear->name',
            '$gear->currentOwnerId',
            '$gear->category',
            '$gear->purchasePrice',
            '$gear->purchaseDate',
            '$gear->purchasePlace')";
        $result = DB::doQuery($sql_query);


        return $result;
    }

    static public function getCategories()
    {
        global $language;

        $sql_query = "SELECT
            Category.CategoryId,
            Category.Title_$language
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

    public static function getAttachment($type, $receiptId) {

        $sql_query = "SELECT
            $type.data,
            $type.type
        FROM $type
        INNER JOIN GearItem ON GearItem.GearId = $type.gearId
        WHERE $type.id = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $receiptId);
        $stmt->execute();

        $stmt->bind_result($row_data, $row_type);

        $attachment = null;
        while ($stmt->fetch()) {
            $attachment = new Attachment();
            $attachment->data = $row_data;
            $attachment->type = $row_type;
        }

        return $attachment;
    }

    private static function getAttachmentDetailsByGearId($type, $gearId)
    {
        $sql_query = "SELECT
            id,
            description,
            type
        FROM $type
        WHERE gearId = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $gearId);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_description, $row_type);
        $result = array();
        while ($stmt->fetch()) {
            $attachment = new Attachment();
            $attachment->id = $row_id;
            $attachment->type = $row_type;
            $attachment->description = $row_description;

            $result[] = $attachment;
        }

        return $result;
    }
}

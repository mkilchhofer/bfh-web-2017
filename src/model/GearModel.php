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
        $receiptIds,
        $pictureIds,
        $warranty;
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
            $gear->id = $row_id;
            $gear->name = $row_gearName;
            $gear->currentOwnerId = $row_currentOwnerId;
            $gear->categoryDescription = $row_categoryDescription;
            $gear->purchasePrice = $row_purchasePrice;
            $gear->purchaseDate = $row_purchaseDate;
            $gear->purchasePlace = $row_purchasePlace;
            $gear->warranty = $row_warranty;

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
            $gear->id = $row_id;
            $gear->name = $row_gearName;
            $gear->currentOwnerId = $row_currentOwnerId;
            $gear->categoryId = $row_categoryId;
            $gear->categoryDescription = $row_categoryDescription;
            $gear->purchasePrice = $row_purchasePrice;
            $gear->purchaseDate = $row_purchaseDate;
            $gear->purchasePlace = $row_purchasePlace;
            $gear->warranty = $row_warranty;
        }

        if ($gear != null) {
            $gear->receiptIds = self::getAttachmentDetailsByGearId('Receipt', $itemId);
            $gear->pictureIds = self::getAttachmentDetailsByGearId('Picture', $itemId);
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

    public static function updateGear($gearId, Gear $gear)
    {
        var_dump($gear);
        echo "<br />";
        var_dump($gearId);

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
            $gearId);

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

    public static function getAttachment($type, $receiptId) {

        $sql_query = "SELECT
            $type.data,
            $type.type
        FROM $type
        INNER JOIN GearItem ON GearItem.id = $type.gearId
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

    private static function uploadAttachment($type, $gearId, $description, $attachmentData, $mimeType){
        $sql_query = "INSERT INTO $type (gearId, description, data, type)
                      VALUES (?,?,?,?)";
        $null = NULL;

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('isbs', $gearId, $description, $null, $mimeType);
        $stmt->send_long_data(2,$attachmentData);

        return $stmt->execute();
    }

    public static function uploadPicture($gearId, $description, $attachmentData, $mimeType) {
        return self::uploadAttachment('Picture',$gearId, $description, $attachmentData, $mimeType);
    }

    public static function uploadReceipt($gearId, $description, $attachmentData, $mimeType) {
        return self::uploadAttachment('Receipt',$gearId, $description, $attachmentData, $mimeType);
    }
}

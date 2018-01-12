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

class AttachmentType extends EntityBase {
    public $title;
}

class Attachment extends EntityBase {
    public $gearId,
        $description,
        $data,
        $mimeType,
        $typeId;
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

    public static function getAttachmentTypes()
    {
        global $language;

        $sql_query = "SELECT
            id,
            title_$language
        FROM AttachmentType";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_title);
        $result = array();
        while ($stmt->fetch()) {
            $attachmentType = new AttachmentType();
            $attachmentType->id = $row_id;
            $attachmentType->title = $row_title;

            $result[] = $attachmentType;
        }

        return $result;
    }

    public static function getAttachment($attachmentId) {

        $sql_query = "SELECT
            Attachment.data,
            Attachment.type
        FROM Attachment
        WHERE Attachment.id = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $attachmentId);
        $stmt->execute();

        $stmt->bind_result($row_data, $row_type);

        $attachment = null;
        while ($stmt->fetch()) {
            $attachment = new Attachment();
            $attachment->data = $row_data;
            $attachment->mimeType = $row_type;
        }

        return $attachment;
    }

    public static function getAttachmentsByGearId($gearId)
    {
        $sql_query = "SELECT
            id,
            typeId,
            description,
            type
        FROM Attachment
        WHERE gearId = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $gearId);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_typeId, $row_description, $row_type);
        $result = array();
        while ($stmt->fetch()) {
            $attachment = new Attachment();
            $attachment->id = $row_id;
            $attachment->typeId = $row_typeId;
            $attachment->mimeType = $row_type;
            $attachment->description = $row_description;

            $result[] = $attachment;
        }

        return $result;
    }

    public static function addAttachment(Attachment $attachment){
        $sql_query = "INSERT INTO Attachment (gearId, typeId, description, data, type)
                      VALUES (?,?,?,?,?)";
        $null = NULL;

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('iisbs', $attachment->gearId, $attachment->typeId, $attachment->description, $null, $attachment->mimeType);
        $stmt->send_long_data(3, $attachment->data);

        return $stmt->execute();
    }

    public static function deleteAttachment($attachmentId, $gearId)
    {
        $sql_query = "DELETE
        FROM Attachment
        WHERE id = ? AND gearId = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('ii', $attachmentId, $gearId);
        return $stmt->execute();
    }
}

<?php
require_once 'core/db.inc.php';
require_once 'model.php';

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

class AttachmentModel
{
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


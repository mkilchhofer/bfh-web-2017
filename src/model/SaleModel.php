<?php
require_once 'core/db.inc.php';
require_once 'model.php';

class Sale extends EntityBase {
    public $name,
        $salesPrice,
        $salesStart,
        $salesEnd,
        $seller,
        $gearId,
        $appearance,
        $functioning,
        $packaging,
        $description;
}

class Appearance extends EntityBase {
    public $title;
}

class Functioning extends EntityBase {
    public $title;
}

class Packaging extends EntityBase {
    public $title;
}

class SaleModel
{

    static public function getSales($userId = null)
    {
        $db = DB::getInstance();
        $current_date = date("Y-m-d H:i:s");
        if ($userId != null){
            $sql_query = "SELECT
                Sale.id,
                Sale.salesPrice,
                Sale.salesEnd,
                GearItem.name,
                GearItem.id,
                User.userName
            FROM Sale
            INNER JOIN GearItem ON Sale.gearId = GearItem.id
            INNER JOIN User ON GearItem.currentOwnerId = User.id
            WHERE Sale.salesStart <= '$current_date' and Sale.salesEnd >= '$current_date'
            AND User.id = ?
            ORDER BY Sale.salesEnd ASC";
            $stmt = $db->prepare($sql_query);
            $stmt->bind_param('i', $userId);
        }
        else{
            $sql_query = "SELECT
                Sale.id,
                Sale.salesPrice,
                Sale.salesEnd,
                GearItem.name,
                GearItem.id,
                User.userName
            FROM Sale
            INNER JOIN GearItem ON Sale.gearId = GearItem.id
            INNER JOIN User ON GearItem.currentOwnerId = User.id
            WHERE Sale.salesStart <= '$current_date' and Sale.salesEnd >= '$current_date'
            ORDER BY Sale.salesEnd ASC";
            $stmt = $db->prepare($sql_query);
        }

        $stmt->execute();

        $stmt->bind_result($row_id, $row_salesPrice, $row_salesEnd, $row_gearName, $row_gearId, $row_userName);
        $result = array();
        while ($stmt->fetch()) {
            $sale = new Sale();
            $sale->id = $row_id;
            $sale->salesPrice = $row_salesPrice;
            $sale->salesEnd = $row_salesEnd;
            $sale->name = $row_gearName;
            $sale->gearId = $row_gearId;
            $sale->seller = $row_userName;

            $result[] = $sale;
        }

        return $result;
    }

    static public function getSaleById($itemId)
    {
        global $language;

        $sql_query = "SELECT
            Sale.id,
            Sale.salesPrice,
            Sale.salesStart,
            Sale.salesEnd,
            Sale.gearId,
            Appearance.title_$language AS Appearance,
            Functioning.title_$language AS Functioning,
            Packaging.title_$language AS Packaging,
            Sale.description,
            GearItem.name,
            User.userName
        FROM Sale
        INNER JOIN GearItem ON Sale.gearId = GearItem.id
        INNER JOIN User ON GearItem.currentOwnerId = User.id
        INNER JOIN Appearance ON Sale.appearanceId = Appearance.id
        INNER JOIN Functioning ON Sale.functioningId = Functioning.id
        INNER JOIN Packaging ON Sale.packagingId = Packaging.id
        WHERE Sale.id = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $itemId);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_salesPrice, $row_salesStart, $row_salesEnd, $row_gearId, $row_Appearance, $row_Functioning, $row_packaging, $row_description, $row_gearName, $row_seller);

        $sale = null;
        while ($stmt->fetch()) {
            $sale = new Sale();
            $sale->id = $row_id;
            $sale->salesPrice = $row_salesPrice;
            $sale->salesStart = $row_salesStart;
            $sale->salesEnd = $row_salesEnd;
            $sale->gearId = $row_gearId;
            $sale->appearance = $row_Appearance;
            $sale->functioning = $row_Functioning;
            $sale->packaging = $row_packaging;
            $sale->description = $row_description;
            $sale->name = $row_gearName;
            $sale->seller = $row_seller;
        }

        return $sale;
    }


    static public function getSaleByGearId($gearId)
    {
        global $language;

        $sql_query = "SELECT
            Sale.id,
            Sale.salesPrice,
            Sale.salesStart,
            Sale.salesEnd,
            Sale.gearId,
            Appearance.title_$language AS Appearance,
            Functioning.title_$language AS Functioning,
            Packaging.title_$language AS Packaging,
            Sale.description,
            GearItem.name,
            User.userName
        FROM Sale
        INNER JOIN GearItem ON Sale.gearId = GearItem.id
        INNER JOIN User ON GearItem.currentOwnerId = User.id
        INNER JOIN Appearance ON Sale.appearanceId = Appearance.id
        INNER JOIN Functioning ON Sale.functioningId = Functioning.id
        INNER JOIN Packaging ON Sale.packagingId = Packaging.id
        WHERE Sale.gearId = ?";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('i', $gearId);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_salesPrice, $row_salesStart, $row_salesEnd, $row_gearId, $row_Appearance, $row_Functioning, $row_packaging, $row_description, $row_gearName, $row_seller);

        $sale = null;
        while ($stmt->fetch()) {
            $sale = new Sale();
            $sale->id = $row_id;
            $sale->salesPrice = $row_salesPrice;
            $sale->salesStart = $row_salesStart;
            $sale->salesEnd = $row_salesEnd;
            $sale->gearId = $row_gearId;
            $sale->appearance = $row_Appearance;
            $sale->functioning = $row_Functioning;
            $sale->packaging = $row_packaging;
            $sale->description = $row_description;
            $sale->name = $row_gearName;
            $sale->seller = $row_seller;
        }

        return $sale;
    }

    public static function getAppearance()
    {
        global $language;

        $sql_query = "SELECT
            id,
            title_$language
        FROM Appearance";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_title);
        $result = array();
        while ($stmt->fetch()) {
            $appearance = new Appearance();
            $appearance->id = $row_id;
            $appearance->title = $row_title;

            $result[] = $appearance;
        }

        return $result;
    }

    public static function getFunctioning()
    {
        global $language;

        $sql_query = "SELECT
            id,
            title_$language
        FROM Functioning";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_title);
        $result = array();
        while ($stmt->fetch()) {
            $functioning = new Functioning();
            $functioning->id = $row_id;
            $functioning->title = $row_title;

            $result[] = $functioning;
        }

        return $result;
    }

    public static function getPackaging()
    {
        global $language;

        $sql_query = "SELECT
            id,
            title_$language
        FROM Packaging";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->execute();

        $stmt->bind_result($row_id, $row_title);
        $result = array();
        while ($stmt->fetch()) {
            $packaging = new Packaging();
            $packaging->id = $row_id;
            $packaging->title = $row_title;

            $result[] = $packaging;
        }

        return $result;
    }


    public static function addSale($userId, Sale $sale)
    {
        $sql_query = "INSERT INTO `Sale` (
            `gearId`,
            `salesPrice`,
            `salesStart`,
            `salesEnd`,
            `appearanceId`,
            `functioningId`,
            `packagingId`,
            `description`)
        VALUES (?,?,?,?,?,?,?,?)";

        $db = DB::getInstance();
        $stmt = $db->prepare($sql_query);
        $stmt->bind_param('idssiiis',
            $sale->gearId,
            $sale->salesPrice,
            $sale->salesStart,
            $sale->salesEnd,
            $sale->appearance,
            $sale->functioning,
            $sale->packaging,
            $sale->description);
        $stmt->execute();

        return $stmt->insert_id;
    }
}

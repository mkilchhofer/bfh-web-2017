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
        $description,
        $pictureIds;
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
        $gearModel = new GearModel();

        global $language;

        $sql_query = "SELECT
            Sale.id,
            Sale.salesPrice,
            Sale.salesStart,
            Sale.salesEnd,
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

        $stmt->bind_result($row_id, $row_salesPrice, $row_salesStart, $row_salesEnd, $row_Appearance, $row_Functioning, $row_packaging, $row_description, $row_gearName, $row_seller);

        $sale = null;
        while ($stmt->fetch()) {
            $sale = new Sale();
            $sale->id = $row_id;
            $sale->salesPrice = $row_salesPrice;
            $sale->salesStart = $row_salesStart;
            $sale->salesEnd = $row_salesEnd;
            $sale->appearance = $row_Appearance;
            $sale->functioning = $row_Functioning;
            $sale->packaging = $row_packaging;
            $sale->description = $row_description;
            $sale->name = $row_gearName;
            $sale->seller = $row_seller;
        }

        if ($sale != null) {
            $sale->receiptIds = $gearModel->getAttachmentDetailsByGearId('Receipt', $itemId);
        }

        return $sale;
    }
}

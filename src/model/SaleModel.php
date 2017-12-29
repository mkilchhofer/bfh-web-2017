<?php
require_once 'core/db.inc.php';

class SaleModel
{

    static public function getSales($ownerId = null)
    {
        $current_date = date("Y-m-d H:i:s");
        if ($ownerId != null){
            $sql_query = "SELECT
                Sale.SaleId,
                Sale.SalesPrice,
                GearItem.GearName,
                GearItem.GearId,
                User.UserName
            FROM Sale
            INNER JOIN GearItem ON Sale.GearId = GearItem.GearId
            INNER JOIN User ON GearItem.CurrentOwnerId = User.UserId
            WHERE Sale.SalesStart <= '$current_date' and Sale.SalesEnd >= '$current_date'
            AND User.UserId = '$ownerId'";
        }
        else{
            $sql_query = "SELECT
                Sale.SaleId,
                Sale.SalesPrice,
                GearItem.GearName,
                User.UserName
            FROM Sale
            INNER JOIN GearItem ON Sale.GearId = GearItem.GearId
            INNER JOIN User ON GearItem.CurrentOwnerId = User.UserId
            WHERE Sale.SalesStart <= '$current_date' and Sale.SalesEnd >= '$current_date'";
        }
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

    static public function getSaleById($saleId)
    {
        global $language;

        $sql_query = "SELECT
            Sale.SaleId,
            Sale.SalesPrice,
            Sale.SalesStart,
            Sale.SalesEnd,
            Appearance.Title_$language AS Appearance,
            Functioning.Title_$language AS Functioning,
            Packaging.Title_$language AS Packaging,
            Sale.Description,
            GearItem.GearName,
            User.UserName
        FROM Sale
        INNER JOIN GearItem ON Sale.GearId = GearItem.GearId
        INNER JOIN User ON GearItem.CurrentOwnerId = User.UserId
        INNER JOIN Appearance ON Sale.Appearance = Appearance.AppearanceId
        INNER JOIN Functioning ON Sale.Functioning = Functioning.FunctioningId
        INNER JOIN Packaging ON Sale.Packaging = Packaging.PackagingId
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

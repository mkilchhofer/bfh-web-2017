<?php
require_once 'constants.php';
require_once 'gear.php';
$gearId = $_GET['id'];
$userId = $_COOKIE['userId'];

$item = Gear::getGearById($gearId);

?>
<h3><?php echo $item['GearName']; ?>
<a href="#" class="btn" role="button" style="float: right">Verkaufen</a>
<a href="#" class="btn" role="button" style="float: right">Bearbeiten</a></h3>

    <table class="table table-striped">
        <tbody id="myTable">
        <tr>
            <th scope="row"><?php echo $lang['picture']; ?></th>
            <td></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $lang['tags']; ?></th>
            <td></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $lang['purchasePrice']; ?></th>
            <td><?php echo $item['PurchasePrice']; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $lang['purchaseDate']; ?></th>
            <td><?php echo $item['PurchaseDate']; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $lang['purchasePlace']; ?></th>
            <td><?php echo $item['PurchasePlace']; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $lang['receiptImageId']; ?></th>
            <td></td>
        </tr>
        </tbody>
    </table>

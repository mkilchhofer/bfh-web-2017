<?php
require_once 'constants.php';
require_once 'GearDbHandler.php';
$gearId = $_GET['id'];
$userId = $_COOKIE['userId'];

$item = GearDbHandler::getGearById($gearId);

?>
<h3><?php echo $item->name; ?>
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
            <td><?php echo $item->purchasePrice; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $lang['purchaseDate']; ?></th>
            <td><?php echo $item->purchaseDate; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $lang['purchasePlace']; ?></th>
            <td><?php echo $item->purchasePlace; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $lang['receiptImageId']; ?></th>
            <td></td>
        </tr>
        </tbody>
    </table>

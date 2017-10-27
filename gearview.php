<?php
require_once ('constants.php');
?>
<h3><?php echo $mygear[$_GET['id']]['title']; ?>
<a href="#" class="btn" role="button" style="float: right">Verkaufen</a>
<a href="#" class="btn" role="button" style="float: right">Bearbeiten</a></h3>

    <table class="table table-striped">
        <tbody id="myTable">
        <tr>
            <th scope="row"><?php echo $strings[$language]['picture']; ?></th>
            <td><?php echo $mygear[$_GET['id']]['picture']; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $strings[$language]['id']; ?></th>
            <td><?php echo $_GET['id'] ; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $strings[$language]['category']; ?></th>
            <td><?php echo $mygear[$_GET['id']]['category']; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $strings[$language]['purchase_price']; ?></th>
            <td><?php echo $mygear[$_GET['id']]['purchase_price']; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $strings[$language]['purchase_date']; ?></th>
            <td><?php echo $mygear[$_GET['id']]['purchase_date']; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $strings[$language]['purchase_location']; ?></th>
            <td><?php echo $mygear[$_GET['id']]['purchase_location']; ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo $strings[$language]['receipt']; ?></th>
            <td>nicht verfügbar</td>
        </tr>
        </tbody>
    </table>

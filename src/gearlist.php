<?php
require_once('GearDbHandler.php');
$userId = $_COOKIE['userId'];

$items = GearDbHandler::getGearByOwner($userId);
?>
    <h3>My Gear
    <a href="?s=add" class="btn" role="button" style="float: right">Neues Gerät erfassen</a></h3>

    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <br>
    <table class="table table-striped">
        <thead>
        <tr>
            <th><?php echo $lang['name']; ?></th>
            <th><?php echo $lang['tags']; ?></th>
            <th><?php echo $lang['purchaseDate']; ?></th>
            <th><?php echo $lang['purchasePrice']; ?></th>
        </tr>
        </thead>
        <tbody id="myTable">
        <?php
            foreach ($items as $item) {
                echo "<tr>";
                echo " <td><a href=\"?s=gearview&id=".$item->id."\">".$item->name."</a></td>";
                echo " <td>".$item->tags."</td>";
                echo " <td>".$item->purchaseDate."</td>";
                echo " <td>".$item->purchasePrice."</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

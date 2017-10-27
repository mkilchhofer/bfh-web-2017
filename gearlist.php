    <h3>My Gear
    <a href="#" class="btn btn-primary" role="button" style="float: right">Neues Gerät erfassen</a></h3>

    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <br>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Gear</th>
            <th>Kategorie</th>
            <th>Kaufdatum</th>
            <th>Preis</th>
        </tr>
        </thead>
        <tbody id="myTable">
        <?php
            foreach ($mygear as $key => $gear) {
                echo "<tr>";
                echo " <td><a href=\"?s=gearview&id=".$key."\">".$gear['title']."</a></td>";
                echo " <td>".$gear['category']."</td>";
                echo " <td>".$gear['purchase_date']."</td>";
                echo " <td>".$gear['currency']." ".$gear['purchase_price']."</td>";
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

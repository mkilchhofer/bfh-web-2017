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
        <tr>
            <td><a href="?s=gearview&?id=1e4e0fae-c4ac-4caf-9731-80b4096fe01d">iPod</a></td>
            <td>Multimedia</td>
            <td>01.02.2009</td>
            <td>CHF 149.00</td>
        </tr>
        <tr>
            <td><a href="?s=gearview&?id=ec15264c-5506-468f-ad00-4ee64237ad2a">Macbook</a></td>
            <td>Multimedia</td>
            <td>01.02.2011</td>
            <td>CHF 1149.00</td>
        </tr>
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

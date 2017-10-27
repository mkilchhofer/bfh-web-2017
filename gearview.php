<h3><?php echo $mygear[$_GET['id']]['title']; ?>
<button type="button" class="btn btn-primary" style="float: right">Verkaufen</button>
<button type="button" class="btn btn-primary" style="float: right">Bearbeiten</button></h3>

    <table class="table table-striped">
        <tbody id="myTable">
        <tr>
            <th scope="row">Bild</th>
            <td><?php echo $mygear[$_GET['id']]['picture']; ?></td>
        </tr>
        <tr>
            <th scope="row">Id</th>
            <td><?php echo $_GET['id'] ; ?></td>
        </tr>
        <tr>
            <th scope="row">Kategorie</th>
            <td><?php echo $mygear[$_GET['id']]['category']; ?></td>
        </tr>
        <tr>
            <th scope="row">Preis</th>
            <td><?php echo $mygear[$_GET['id']]['price']; ?></td>
        </tr>
        <tr>
            <th scope="row">Kaufdatum</th>
            <td><?php echo $mygear[$_GET['id']]['purchase_date']; ?></td>
        </tr>
        <tr>
            <th scope="row">Gekauft bei:</th>
            <td><?php echo $mygear[$_GET['id']]['purchase_location']; ?></td>
        </tr>
        <tr>
            <th scope="row">Quittung:</th>
            <td>nicht verfügbar</td>
        </tr>
        </tbody>
    </table>

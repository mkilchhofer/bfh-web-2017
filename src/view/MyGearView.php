<?php

class MyGearView
{
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderGearList() {
        require_once('core/authentication.inc.php');
        global $lang;
        $items = $this->model->getGearByOwner($_SESSION['userId']);

        echo <<<GEARLIST1
         <h3>My Gear
            <a href="add" class="btn" role="button" style="float: right">Neues Gerät erfassen</a></h3>
        
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
            <br>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{$lang['name']}</th>
                    <th>{$lang['tags']}</th>
                    <th>{$lang['purchaseDate']}</th>
                    <th>{$lang['purchasePrice']}</th>
                </tr>
                </thead>
                <tbody id="myTable">
GEARLIST1;

            foreach ($items as $item) {
                echo "<tr>";
                echo " <td><a href=\"showDetail/".$item->id."\">".$item->name."</a></td>";
                echo " <td>".$item->tags."</td>";
                echo " <td>".$item->purchaseDate."</td>";
                echo " <td>".$item->purchasePrice."</td>";
                echo "</tr>";
            }

        echo <<<GEARLIST2
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
GEARLIST2;
    }

    public function renderDetailView($id) {
        require_once('core/authentication.inc.php');
        global $lang;
        $item = $this->model->getGearById($id);

        echo <<< GEARDETAIL
<h3>{$item->name}
<a href="../delete/{$id}" class="btn" role="button" style="float: right">Löschen</a>
<a href="../sell/{$id}" class="btn" role="button" style="float: right">Verkaufen</a>
<a href="../edit/{$id}" class="btn" role="button" style="float: right">Bearbeiten</a></h3>

    <table class="table table-striped">
        <tbody id="myTable">
        <tr>
            <th scope="row">{$lang['picture']}</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row">{$lang['tags']}</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row">{$lang['purchasePrice']}</th>
            <td>{$item->purchasePrice}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['purchaseDate']}</th>
            <td>{$item->purchaseDate}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['purchasePlace']}</th>
            <td>{$item->purchasePlace}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['receiptImageId']}</th>
            <td></td>
        </tr>
        </tbody>
    </table>
GEARDETAIL;
    }

    public function renderGearAdd() {
        require_once('core/authentication.inc.php');
        global $lang;

        echo <<< GEARADD
<h3>Add new device</h3>

<form action="store" method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label for="uploadPicture">Upload Picture</label>
        <input type="file" class="form-control" name="uploadPicture">
    </div>
    <div class="form-group">
        <label for="category">Select category</label>
        <select class="form-control" id="category">
            <option>Notebook</option>
            <option>Camera Body</option>
            <option>Camera Lens</option>
            <option>Smartphone</option>
            <option>Tablet computer</option>
        </select>
    </div>
    <div class="form-group">
        <label for="purchasePrice">Purchase Price</label>
        <input type="number" class="form-control" name="purchasePrice" min="0.00" step="0.01">
    </div>
    <div class="form-group">
        <label for="purchaseDate">Purchase Date</label>
        <input type="date" class="form-control" name="purchaseDate">
    </div>
    <div class="form-group">
        <label for="purchasedFrom">Purchased From</label>
        <input type="text" class="form-control" name="purchasedPlace">
    </div>
    <div class="form-group">
        <label for="uploadReceipt">Upload Receipt</label>
        <input type="file" class="form-control" name="uploadReceipt">
    </div>
    <button type="submit" class="btn btn-default">Add Device</button>
</form>
GEARADD;
    }

    public function renderGearStore() {
        require_once('core/authentication.inc.php');
        global $lang;

        $gear = new Gear(null, $_POST['name'], $_SESSION['userId'], $_POST['purchasePrice'], $_POST['purchaseDate'], $_POST['purchasedPlace']);
        $result = $this->model->addGear($gear);

        if ($result) {
            echo "added, <a href=\"showList\">Go to My Gear</a>";
        } else {
            echo "not added, <a href=\"javascript:history.back()\">Go Back</a>";
        }
    }
}

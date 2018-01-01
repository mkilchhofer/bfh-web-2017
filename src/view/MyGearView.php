<?php
require_once(__DIR__ . '/../TemplateHelper.php');

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
        TemplateHelper::renderHeader();

        echo <<<GEARLIST1
         <h3>{$lang['nav_mygear']}
            <a href="add" class="btn" role="button" style="float: right">{$lang['addNewDevice']}</a></h3>
        
            <input class="form-control" id="myInput" type="text" placeholder="{$lang['search']}">
            <br>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{$lang['name']}</th>
                    <th>{$lang['category']}</th>
                    <th>{$lang['purchaseDate']}</th>
                    <th>{$lang['purchasePrice']}</th>
                </tr>
                </thead>
                <tbody id="myTable">
GEARLIST1;

            foreach ($items as $item) {
                echo "<tr>";
                echo " <td><a href=\"showDetail/".$item->id."\">".$item->name."</a></td>";
                echo " <td>".$item->category."</td>";
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
        TemplateHelper::renderFooter();
    }

    public function renderDetailView($id) {
        require_once('core/authentication.inc.php');
        global $lang;
        $item = $this->model->getGearById($_SESSION['userId'], $id);
        TemplateHelper::renderHeader();

        echo <<< GEARDETAIL
<h3>{$item->name}
<a href="../delete/{$id}" class="btn" role="button" style="float: right">{$lang['delete']}</a>
<a href="../sell/{$id}" class="btn" role="button" style="float: right">{$lang['sell']}</a>
<a href="../edit/{$id}" class="btn" role="button" style="float: right">{$lang['edit']}</a></h3>

    <table class="table table-striped">
        <tbody id="myTable">
        <tr>
            <th scope="row">{$lang['picture']}</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row">{$lang['category']}</th>
            <td>{$item->category}</td>
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
        TemplateHelper::renderFooter();
    }

    public function renderGearAdd() {
        require_once('core/authentication.inc.php');
        global $lang;
        $categories = $this->model->getCategories();
        TemplateHelper::renderHeader();

        echo <<< GEARADD1
<h3>{$lang['addNewDevice']}</h3>

<form action="store" method="post">
    <div class="form-group">
        <label for="name">{$lang['name']}</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label for="category">Select category</label>
        <select class="form-control" name="category">
GEARADD1;
        foreach ($categories as $category) {
            echo "<option value=".$category->id.">".$category->title."</option>";

        }
        echo <<< GEARADD2
        </select>
    </div>
    <div class="form-group">
        <label for="purchasePrice">{$lang['purchasePrice']}</label>
        <input type="number" class="form-control" name="purchasePrice" min="0.00" step="0.01">
    </div>
    <div class="form-group">
        <label for="purchaseDate">{$lang['purchaseDate']}</label>
        <input type="date" class="form-control" name="purchaseDate">
    </div>
    <div class="form-group">
        <label for="purchasedFrom">{$lang['purchasePlace']}</label>
        <input type="text" class="form-control" name="purchasedPlace">
    </div>
    <button type="submit" class="btn btn-default">{$lang['btn_add']}</button>
</form>
GEARADD2;
        TemplateHelper::renderFooter();
    }

    public function renderGearStore() {
        require_once('core/authentication.inc.php');
        global $lang;
        TemplateHelper::renderHeader();


        $gear = new Gear();
        $gear->name = $_POST['name'];
        $gear->currentOwnerId = $_SESSION['userId'];
        $gear->category = $_POST['category'];
        $gear->purchasePrice = $_POST['purchasePrice'];
        $gear->purchaseDate = $_POST['purchaseDate'];
        $gear->purchasePlace = $_POST['purchasedPlace'];

        $result = $this->model->addGear($gear);

        if ($result) {
            echo "added, <a href=\"showList\">Go to My Gear</a>";
        } else {
            echo "not added, <a href=\"javascript:history.back()\">Go Back</a>";
        }
        TemplateHelper::renderFooter();
    }
}

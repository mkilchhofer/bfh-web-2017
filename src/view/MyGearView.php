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

        $tableData = '';
        foreach ($items as $item) {
            $tableData .= "<tr>";
            $tableData .= " <td><a href=\"showDetail/".$item->id."\">".$item->name."</a></td>";
            $tableData .= " <td>".$item->category."</td>";
            $tableData .= " <td>".$item->purchaseDate."</td>";
            $tableData .= " <td>".$item->purchasePrice."</td>";
            $tableData .= "</tr>";
        }

        echo <<<GEARLIST
         <h3>
            {$lang['nav_mygear']}
            <a href="add" class="btn btn-outline-primary" role="button" style="float: right">{$lang['addNewDevice']}</a>
         </h3>
        
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
                {$tableData}
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
GEARLIST;
        TemplateHelper::renderFooter();
    }

    public function renderDetailView($id) {
        require_once('core/authentication.inc.php');
        global $lang;
        $item = $this->model->getGearById($_SESSION['userId'], $id);

        TemplateHelper::renderHeader();

        $imgReceipt = '';
        foreach ($item->receiptIds as $attachment) {
            $type = explode('/', $attachment->type);
            $imgReceipt .= "- <a href=\"../showReceipt/$attachment->id\">$attachment->description ($type[1])</a><br />";
        }
        if(empty($imgReceipt)){
            $imgReceipt = $lang['noReceipts'];
        }

        $imgPictures = '';
        foreach ($item->pictureIds as $attachment) {
            $imgPictures .= "<img src=\"../showPicture/$attachment->id\" class=\"img-responsive\" />";
        }
        if(empty($imgPictures)){
            $imgPictures = $lang['noPictures'];
        }

        echo <<< GEARDETAIL
<h3>{$item->name}
<a href="../delete/{$id}" class="btn" role="button" style="float: right">{$lang['delete']}</a>
<a href="../sell/{$id}" class="btn" role="button" style="float: right">{$lang['sell']}</a>
<a href="../edit/{$id}" class="btn" role="button" style="float: right">{$lang['edit']}</a></h3>

    <table class="table table-striped">
        <tbody id="myTable">
        <tr>
            <th scope="row">{$lang['picture']}</th>
            <td>{$imgPictures}</td>
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
            <td>{$imgReceipt}</td>
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

        $select_category = '';
        foreach ($categories as $category) {
            $select_category .= "<option value=".$category->id.">".$category->title."</option>";
        }

        echo <<< GEARADD
<h3>{$lang['addNewDevice']}</h3>

<form action="store" method="post">
    <div class="form-group">
        <label for="name">{$lang['name']}</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label for="category">Select category</label>
        <select class="form-control" name="category">
        {$select_category}
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
GEARADD;
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

    public function renderAttachment($type, $id){
        $attachment = $this->model->getAttachment($type, $id);

        header("Content-type: $attachment->type");
        echo $attachment->data;
    }
}

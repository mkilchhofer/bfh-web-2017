<?php
require_once(__DIR__ . '/../TemplateHelper.php');

class MyGearView
{
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderGearList($items) {
        global $lang;
        TemplateHelper::renderHeader($lang['nav_mygear']);

        $tableData = '';
        foreach ($items as $item) {
            $tableData .= "<tr>";
            $tableData .= " <td><a href=\"showDetail/".$item->id."\">".$item->name."</a></td>";
            $tableData .= " <td>".$item->categoryDescription."</td>";
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
        <br />
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

    public function renderDetailView($item) {
        global $lang;
        TemplateHelper::renderHeader($item->name);

        $imgReceipt = '';
        if (isset($item->receiptIds)) {
            foreach ($item->receiptIds as $attachment) {
                $type = explode('/', $attachment->type);
                $imgReceipt .= "- <a href=\"../showReceipt/$attachment->id\">$attachment->description ($type[1])</a><br />";
            }
        } else {
            $imgReceipt = $lang['noReceipts'];
        }

        $imgPictures = '';
        $imgPictures .= '<div id="links">';
        if (isset($item->pictureIds)){
            foreach ($item->pictureIds as $attachment) {
                $imgPictures .= "<a href=\"../showPicture/$attachment->id\" title=\"{$attachment->description}\"><img src=\"../showPictureResized/$attachment->id\" /> </a> ";
            }
        } else {
            $imgPictures .= $lang['noPictures'];
        }
        $imgPictures .= '</div>';

        echo <<< GEARDETAIL
        <h3>
            {$item->name}
            <a href="../delete/{$item->id}" class="btn" role="button" style="float: right">{$lang['delete']}</a>
            <a href="../sell/{$item->id}" class="btn" role="button" style="float: right">{$lang['sell']}</a>
            <a href="../edit/{$item->id}" class="btn" role="button" style="float: right">{$lang['edit']}</a>
        </h3>
        <table class="table table-striped">
            <tbody id="myTable">
            <tr>
                <th scope="row">
                    {$lang['picture']}<br />
                    <a href="../addPicture/{$item->id}" class="btn btn-outline-primary" role="button"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </th>
                <td>{$imgPictures}</td>
            </tr>
            <tr>
                <th scope="row">{$lang['category']}</th>
                <td>{$item->categoryDescription}</td>
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
                <th scope="row">{$lang['warranty']}</th>
                <td>{$item->warranty}</td>
            </tr>
            <tr>
                <th scope="row">{$lang['purchasePlace']}</th>
                <td>{$item->purchasePlace}</td>
            </tr>
            <tr>
                <th scope="row">
                    {$lang['receiptImageId']}<br />
                    <a href="../addReceipt/{$item->id}" class="btn btn-outline-primary" role="button"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </th>
                <td>{$imgReceipt}</td>
            </tr>
            </tbody>
        </table>
GEARDETAIL;
        TemplateHelper::renderFooter();
    }

    public function renderGearForm($title, $userId, $categories, $gearItem, $formAction) {
        global $lang;
        TemplateHelper::renderHeader($title);

        $select_category = '';
        foreach ($categories as $category) {
            $selectedCategory = '';
            if($gearItem->categoryId == $category->id){
                $selectedCategory = 'selected="selected"';
            }
            $select_category .= "<option value=\"$category->id\" $selectedCategory>$category->title</option>";
        }

        echo <<< GEARADD
        <h3>
            {$title}
        </h3>
        <form action="{$formAction}" method="post">
            <div class="form-group">
                <label for="name">{$lang['name']}</label>
                <input type="text" class="form-control" name="name" value="{$gearItem->name}">
                <input type="hidden" class="form-control" name="userId" value="{$userId}">
                <input type="hidden" class="form-control" name="gearId" value="{$gearItem->id}">
            </div>
            <div class="form-group">
                <label for="category">Select category</label>
                <select class="form-control" name="categoryId">
                {$select_category}
                </select>
            </div>
            <div class="form-group">
                <label for="purchasePrice">{$lang['purchasePrice']}</label>
                <input type="number" class="form-control" name="purchasePrice" min="0.00" step="0.01" value="{$gearItem->purchasePrice}">
            </div>
            <div class="form-group">
                <label for="purchaseDate">{$lang['purchaseDate']}</label>
                <input type="date" class="form-control" name="purchaseDate" value="{$gearItem->purchaseDate}">
            </div>
            <div class="form-group">
                <label for="purchasedFrom">{$lang['warranty']}</label>
                <input type="date" class="form-control" name="warranty" value="{$gearItem->warranty}">
            </div>
            <div class="form-group">
                <label for="purchasedFrom">{$lang['purchasePlace']}</label>
                <input type="text" class="form-control" name="purchasedPlace" value="{$gearItem->purchasePlace}">
            </div>
            <button type="submit" class="btn btn-default">{$title}</button>
        </form>
GEARADD;
        TemplateHelper::renderFooter();
    }

    public function renderAttachment($attachment){
        header("Content-type: $attachment->type");
        echo $attachment->data;
    }

    public function renderAttachmentResized($attachment, $size) {
        require_once(__DIR__ . '/../core/smart_resize_image.function.php');
        smart_resize_image(null, $attachment->data, $size, $size,true,'browser',false,false,100);
    }

    public function renderGearUploadPicture($userId, $id) {
        self::renderGearUploadAttachment($userId, $id, '../uploadPicture');
    }

    public function renderGearUploadReceipt($userId, $id) {
        self::renderGearUploadAttachment($userId, $id, '../uploadReceipt');
    }

    private function renderGearUploadAttachment($userId, $id, $formAction) {
        global $lang;
        TemplateHelper::renderHeader('Upload');

        echo <<< GEARADD
        <h3>
            Upload
        </h3>
        <form action="{$formAction}" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="uploadPicture">{$lang['picture']} - Beschreibung</label>
            <input type="hidden" class="form-control" name="userId" value="{$userId}">
            <input type="hidden" class="form-control" name="gearId" value="{$id}">
            <input type="text" class="form-control" name="attachmentDescription">
            <label for="uploadPicture">{$lang['picture']}</label>
            <input type="file" class="form-control" name="attachmentData">
        </div>
        <button type="submit" class="btn btn-default">Upload</button>
        </form>
GEARADD;
        TemplateHelper::renderFooter();
    }
}

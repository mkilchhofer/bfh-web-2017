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
        $title = $lang['nav_mygear'];
        TemplateHelper::renderHeader($title);

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
            {$title}
        </h3>
        <div class="row">
            <div class="col-md-3">
                <a href="add" class="btn btn-outline-primary" role="button">{$lang['addNewDevice']}</a>
            </div>
            <div class="col-md-9 text-right">
                <input class="form-control" id="myInput" type="text" placeholder="{$lang['search']}">
            </div>
        </div>
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

    public function renderDetailView($item, $attachments) {
        global $lang;
        $title = $item->name;
        TemplateHelper::renderHeader($title);

        $imgReceipt = '';
        $imgPictures = '<div id="image-gallery">';

        foreach ($attachments as $attachment) {

            // Receipts
            if($attachment->typeId == 2){
                $type = explode('/', $attachment->mimeType)[1];
                $imgReceipt .= "- <a href=\"../../Attachment/show/$attachment->id\">
                                    $attachment->description ($type)
                                  </a><br />";
            }

            // Pictures
            if($attachment->typeId == 1){
                $imgPictures .= "<a href=\"../../Attachment/show/$attachment->id\" title=\"{$attachment->description}\">
                                    <img src=\"../../Attachment/preview/$attachment->id\" alt=\"{$attachment->description}\" />
                                 </a> ";
            }

        }
        $imgPictures .= '</div>';

        echo <<< GEARDETAIL
        <h3>
            {$title}
        </h3>
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="../../Attachment/upload/{$item->id}" class="btn btn-outline-primary"><i class="fa fa-upload" aria-hidden="true"></i></a>
            <a href="../edit/{$item->id}" class="btn btn-outline-primary" role="button">{$lang['edit']}</a>
            <a href="../sell/{$item->id}" class="btn btn-outline-primary" role="button">{$lang['sell']}</a>
            <a href="../delete/{$item->id}" class="btn btn-outline-danger" role="button">{$lang['delete']}</a>
        </div>
        <br /><br />

        <table class="table table-striped">
            <tbody id="myTable">
            <tr>
                <th scope="row">{$lang['picture']}</th>
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
                <th scope="row">{$lang['receiptImageId']}</th>
                <td>{$imgReceipt}</td>
            </tr>
            </tbody>
        </table>
        <script>
        document.getElementById('image-gallery').onclick = function (event) {
            event = event || window.event;
            var target = event.target || event.srcElement,
                link = target.src ? target.parentNode : target,
                options = {index: link, event: event},
                links = this.getElementsByTagName('a');
            blueimp.Gallery(links, options);
        };
        </script>
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

}

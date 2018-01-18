<?php
require_once(__DIR__ . '/../TemplateHelper.php');

class MarketplaceView
{
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderList()
    {
        global $lang;
        $saleItems = $this->model->getSales();
        TemplateHelper::renderHeader();

        $tableData = '';
        foreach ($saleItems as $saleItem) {
            $tableData .= "<tr>";
            $tableData .= " <td><a href=\"showDetail/" . $saleItem->id . "\">" . $saleItem->name . "</a></td>";
            $tableData .= " <td>" . $saleItem->salesPrice . "</td>";
            $tableData .= " <td>" . $saleItem->salesEnd . "</td>";
            $tableData .= " <td>" . $saleItem->seller . "</td>";
            $tableData .= "</tr>";
        }

        echo <<< LIST
         <h3>{$lang['nav_marketplace']}</h3>
            <input class="form-control" id="myInput" type="text" placeholder="{$lang['search']}">
            <br>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{$lang['name']}</th>
                    <th>{$lang['salesPrice']}</th>
                    <th>{$lang['salesEnd']}</th>
                    <th>{$lang['seller']}</th>
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
LIST;
        TemplateHelper::renderFooter();
    }


    public function renderDetailView($saleId) {
        global $lang;
        $gearModel = new GearModel();
        $attachmentModel = new AttachmentModel();
        $saleById = $this->model->getSaleById($saleId);
        $attachments = $attachmentModel->getAttachmentsByGearId($saleById->gearId);

        $imgPictures = '<div id="image-gallery">';
        foreach ($attachments as $attachment) {
            // Pictures
            if($attachment->typeId == 1){
                $imgPictures .= "<a href=\"../../Attachment/show/$attachment->id\" title=\"{$attachment->description}\">
                                    <img src=\"../../Attachment/preview/$attachment->id\" alt=\"{$attachment->description}\" />
                                 </a> ";
            }
        }
        $imgPictures .= '</div>';

        TemplateHelper::renderHeader();
        echo <<< GEARDETAIL
<h3>{$saleById->name}</h3>
    <a href="../contactSeller/{$saleId}" class="btn btn-outline-primary" role="button">{$lang['contactSeller']}</a>
    <br />
    <br />

    <table class="table table-striped">
        <tbody id="myTable">
        <tr>
            <th scope="row">{$lang['picture']}</th>
            <td>{$imgPictures}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['description']}</th>
            <td>{$saleById->description}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['salesPrice']}</th>
            <td>{$saleById->salesPrice}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['appearance']}</th>
            <td>{$saleById->appearance}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['functioning']}</th>
            <td>{$saleById->functioning}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['packaging']}</th>
            <td>{$saleById->packaging}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['seller']}</th>
            <td>{$saleById->seller}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['salesStart']}</th>
            <td>{$saleById->salesStart}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['salesEnd']}</th>
            <td>{$saleById->salesEnd}</td>
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

    public function renderBuyContactForm($userId, $saleId) {
        global $lang;
        TemplateHelper::renderHeader();

        echo <<< REGISTERFORM
        <h3>{$lang['contactSeller']}</h3>
        <form action="../processMessage" method="post">
          <div class="form-group">
            <input type="hidden" class="form-control" name="userId" value="{$userId}">
            <input type="hidden" class="form-control" name="saleId" value="{$saleId}">
            <label for="exampleTextarea">Mitteilung an Inserent</label>
            <textarea class="form-control" id="exampleTextarea" rows="10" name="message"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
REGISTERFORM;

        TemplateHelper::renderFooter();
    }

    public function renderContactConfirmation() {
        global $lang;
        global $language;

        TemplateHelper::renderHeader();
        echo "<div class=\"alert alert-success\" role=\"alert\">{$lang['mail_successful']}</div>";
        TemplateHelper::renderFooter();
    }

    public function renderContactError($errorMsg) {
        global $lang;
        global $language;

        TemplateHelper::renderHeader();
        echo "<div class=\"alert alert-danger\" role=\"alert\">{$lang['mail_failed']}</div>";
        echo $errorMsg;
        TemplateHelper::renderFooter();
    }
}

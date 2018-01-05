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
        $saleById = $this->model->getSaleById($saleId);

        TemplateHelper::renderHeader();
        echo <<< GEARDETAIL
<h3>{$saleById->name}</h3>
    <table class="table table-striped">
        <tbody id="myTable">
        <tr>
            <th scope="row">{$lang['picture']}</th>
            <td></td>
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
GEARDETAIL;
        TemplateHelper::renderFooter();
    }
}

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

        echo <<< LIST1
         <h3>{$lang['nav_marketplace']}</h3>
            <input class="form-control" id="myInput" type="text" placeholder="{$lang['search']}">
            <br>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{$lang['name']}</th>
                    <th>{$lang['salesPrice']}</th>
                    <th>{$lang['seller']}</th>
                </tr>
                </thead>
                <tbody id="myTable">
LIST1;

        foreach ($saleItems as $saleItem) {
            echo "<tr>";
            echo " <td><a href=\"showDetail/" . $saleItem['SaleId'] . "\">" . $saleItem['GearName'] . "</a></td>";
            echo " <td>" . $saleItem['SalesPrice'] . "</td>";
            echo " <td>" . $saleItem['UserName'] . "</td>";
            echo "</tr>";
        }

        echo <<< LIST2
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
LIST2;
        TemplateHelper::renderFooter();
    }


    public function renderDetailView($saleId) {
        global $lang;
        $saleById = $this->model->getSaleById($saleId);

        TemplateHelper::renderHeader();
        echo <<< GEARDETAIL
<h3>{$saleById['GearName']}</h3>
    <table class="table table-striped">
        <tbody id="myTable">
        <tr>
            <th scope="row">{$lang['picture']}</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row">{$lang['description']}</th>
            <td>{$saleById['Description']}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['salesPrice']}</th>
            <td>{$saleById['SalesPrice']}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['appearance']}</th>
            <td>{$saleById['Appearance']}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['functioning']}</th>
            <td>{$saleById['Functioning']}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['packaging']}</th>
            <td>{$saleById['Packaging']}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['seller']}</th>
            <td>{$saleById['UserName']}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['salesStart']}</th>
            <td>{$saleById['SalesStart']}</td>
        </tr>
        <tr>
            <th scope="row">{$lang['salesEnd']}</th>
            <td>{$saleById['SalesEnd']}</td>
        </tr>
        </tbody>
    </table>
GEARDETAIL;
        TemplateHelper::renderFooter();
    }
}

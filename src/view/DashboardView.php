<?php
require_once(__DIR__ . '/../TemplateHelper.php');

class DashboardView
{
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderList()
    {
        require_once('core/authentication.inc.php');
        global $lang;
        $saleItems = $this->model->getSales($_SESSION['userId']);

        TemplateHelper::renderHeader();
        echo <<< LIST1
  <div class="container">
  <div class="row">
    <div class="col-sm-6">
            <h3>My Items on sale</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{$lang['name']}</th>
                    <th>{$lang['salesPrice']}</th>
                    <th>{$lang['salesEnd']}</th>
                </tr>
                </thead>
                <tbody id="myTable">
LIST1;

        foreach ($saleItems as $saleItem) {
            echo "<tr>";
            echo " <td><a href=\"../MyGear/showDetail/" . $saleItem->gearId . "\">" . $saleItem->name . "</a></td>";
            echo " <td>" . $saleItem->salesPrice . "</td>";
            echo " <td>" . $saleItem->salesEnd . "</td>";
            echo "</tr>";
        }

        echo <<< LIST2
                </tbody>
            </table>
    </div>
    <div class="col-sm-6">
    <h3>Other Things</h3>
    Welcome back, User {$_SESSION['userId']}
    </div>
  </div>
LIST2;
        TemplateHelper::renderFooter();
    }
}

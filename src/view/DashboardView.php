<?php

class DashboardView
{
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderList()
    {
        global $lang;
        $saleItems = $this->model->getSales($_SESSION['userId']);

        echo <<< LIST1
         <h3>My Items on sale</h3>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{$lang['name']}</th>
                    <th>{$lang['salesPrice']}</th>
                </tr>
                </thead>
                <tbody id="myTable">
LIST1;

        foreach ($saleItems as $saleItem) {
            echo "<tr>";
            echo " <td><a href=\"../MyGear/showDetail/" . $saleItem['GearId'] . "\">" . $saleItem['GearName'] . "</a></td>";
            echo " <td>" . $saleItem['SalesPrice'] . "</td>";
            echo "</tr>";
        }

        echo <<< LIST2
                </tbody>
            </table>
LIST2;
    }
}

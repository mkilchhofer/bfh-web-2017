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
        $userId = $_SESSION['userId'];
        $saleItems = $this->model->getSales($userId);
        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);

        $itemsOnSale = '';
        foreach ($saleItems as $saleItem) {
            $itemsOnSale .= "<tr>";
            $itemsOnSale .= "<td><a href=\"../MyGear/showDetail/" . $saleItem->gearId . "\">" . $saleItem->name . "</a></td>";
            $itemsOnSale .= "<td>" . $saleItem->salesPrice . "</td>";
            $itemsOnSale .= "<td>" . $saleItem->salesEnd . "</td>";
            $itemsOnSale .= "</tr>";
        }

        TemplateHelper::renderHeader();
        echo <<< LIST
        <div class="row">
            <div class="col-sm-6">
                <h3>{$lang['yourSaleItems']}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{$lang['name']}</th>
                        <th>{$lang['salesPrice']}</th>
                        <th>{$lang['salesEnd']}</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                        {$itemsOnSale}
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
            <h3>{$lang['news']}</h3>
            {$lang['welcomeBack']}, {$user->firstName} {$user->lastName}
            </div>
        </div>
LIST;
        TemplateHelper::renderFooter();
    }
}

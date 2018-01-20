<?php
require_once(__DIR__ . '/../TemplateHelper.php');
require_once(__DIR__ . '/ViewBase.php');

class AdminView extends ViewBase
{

    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderList($userId) {
        global $lang;
        global $language;
        TemplateHelper::renderHeader();
        $title = $lang['allUsers'];

        $users = $this->model->getUsers();

        $tableData = '';
        foreach ($users as $user) {
            $tableData .= "<tr>";
            $tableData .= " <td>".$user->id."</td>";
            $tableData .= " <td>".$user->userName."</td>";
            $tableData .= " <td>".$user->firstName."</td>";
            $tableData .= " <td>".$user->lastName."</td>";
            $tableData .= " <td>".$user->email."</td>";
            if($user->admin){
                $tableData .= '<td><i class="fa fa-check" aria-hidden="true"></i></td>';
            } else {
                $tableData .= "<td></td>";
            }

            if($userId != $user->id){
                $tableData .= ' <td>
                                  <a href="deleteUser/'.$user->id.'" class="btn btn-outline-danger btn-sm" role="button">'.$lang['delete'].'</a>
                                  <a href="toggleAdmin/'.$user->id.'" class="btn btn-outline-warning btn-sm" role="button">'.$lang['toggleAdmin'].'</a>
                                </td>';
            } else {
                $tableData .= ' <td>
                                  <a href="#" class="btn btn-outline-secondary btn-sm" role="button"><s>'.$lang['delete'].'</s></a>
                                  <a href="#" class="btn btn-outline-secondary btn-sm" role="button"><s>'.$lang['toggleAdmin'].'</s></a>
                                </td>';
            }
            $tableData .= '</tr>';
        }

        echo <<<GEARLIST
        <h3>
            {$title}
        </h3>
        <input class="form-control" id="myInput" type="text" placeholder="{$lang['search']}">
        <br />
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{$lang['id']}</th>
                <th>{$lang['userName']}</th>
                <th>{$lang['firstName']}</th>
                <th>{$lang['lastName']}</th>
                <th>{$lang['email']}</th>
                <th>{$lang['admin']}</th>
                <th>{$lang['actions']}</th>
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


    public function renderGearList($items) {
        global $lang;
        $title = $lang['allDevices'];
        TemplateHelper::renderHeader($title);

        $tableData = '';
        foreach ($items as $item) {
            $tableData .= "<tr>";
            $tableData .= " <td>".$item->id."</td>";
            $tableData .= " <td>".$item->name."</td>";
            $tableData .= " <td>".$item->categoryDescription."</td>";
            $tableData .= " <td>".$item->ownerUserName."</td>";
            $tableData .= ' <td><a href="deleteGear/'.$item->id.'">'.$lang['delete'].'</a></td>';
            $tableData .= "</tr>";
        }

        echo <<<GEARLIST
        <h3>
            {$title}
        </h3>
        <input class="form-control" id="myInput" type="text" placeholder="{$lang['search']}">
        <br />
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{$lang['id']}</th>
                <th>{$lang['name']}</th>
                <th>{$lang['category']}</th>
                <th>{$lang['userName']}</th>
                <th>{$lang['actions']}</th>
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
}

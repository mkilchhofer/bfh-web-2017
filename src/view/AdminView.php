<?php
require_once(__DIR__ . '/../TemplateHelper.php');

class AdminView
{

    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderList($userId) {
        global $lang;
        global $language;
        TemplateHelper::renderHeader();
        $title = 'Admin';

        $users = $this->model->getUsers();

        $tableData = '';
        foreach ($users as $user) {
            $tableData .= "<tr>";
            $tableData .= " <td><a href=\"showUser/".$user->id."\">".$user->userName."</a></td>";
            $tableData .= " <td>".$user->firstName."</td>";
            $tableData .= " <td>".$user->lastName."</td>";
            $tableData .= " <td>".$user->email."</td>";
            if($user->admin){
                $tableData .= "<td><i class=\"fa fa-check\" aria-hidden=\"true\"></i></td>";
            } else {
                $tableData .= "<td></td>";
            }

            if($userId != $user->id){
                $tableData .= " <td><a href=\"deleteUser/".$user->id."\">".$lang['delete']."</a></td>";
            } else {
                $tableData .= " <td><s>".$lang['delete']."</s></td>";
            }
            $tableData .= "</tr>";
        }

        echo <<<GEARLIST
        <h3>
            {$title}
        </h3>
        <div class="row">
            <input class="form-control" id="myInput" type="text" placeholder="{$lang['search']}">
        </div>
        <br />
        <table class="table table-striped">
            <thead>
            <tr>
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
}

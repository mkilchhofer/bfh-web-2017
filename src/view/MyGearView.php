<?php


class MyGearView
{

    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function renderGearList() {
        global $lang;

        //$items = $this->model->getGearByOwner($_SESSION['userId']);
        $items = $this->model->getGearByOwner(1);
        var_dump($items);


        echo <<<GEARLIST1
         <h3>My Gear
            <a href="?s=add" class="btn" role="button" style="float: right">Neues Gerät erfassen</a></h3>
        
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
            <br>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{$lang['name']}</th>
                    <th>{$lang['tags']}</th>
                    <th>{$lang['purchaseDate']}</th>
                    <th>{$lang['purchasePrice']}</th>
                </tr>
                </thead>
                <tbody id="myTable">
GEARLIST1;

            foreach ($items as $item) {
                echo "<tr>";
                echo " <td><a href=\"?s=gearview&id=".$item->id."\">".$item->name."</a></td>";
                echo " <td>".$item->tags."</td>";
                echo " <td>".$item->purchaseDate."</td>";
                echo " <td>".$item->purchasePrice."</td>";
                echo "</tr>";
            }
        echo <<<GEARLIST2
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
GEARLIST2;



    }

    public function renderDetailView($id) {

    }


}

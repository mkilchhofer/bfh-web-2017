<?php

class Gear {
    public $id, $name, $currentOwnerId, $purchasePrice, $purchaseDate, $purchasePlace;

    function __construct($id, $name, $currentOwnerId, $purchasePrice, $purchaseDate, $purchasePlace) {
        $this->id = $id;
        $this->name = $name;
        $this->currentOwnerId = $currentOwnerId;
        $this->purchasePrice = $purchasePrice;
        $this->purchaseDate = $purchaseDate;
        $this->purchasePlace = $purchasePlace;
    }
}

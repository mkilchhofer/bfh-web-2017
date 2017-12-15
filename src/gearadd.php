<?php
require_once ('constants.php');
include "authentication.inc.php";
?>

<h3>Add new device</h3>

<form action="gearaddpost.php" method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name">
    </div>
    <div class="form-group">
        <label for="uploadPicture">Upload Picture</label>
        <input type="file" class="form-control" name="uploadPicture">
    </div>
    <div class="form-group">
        <label for="category">Select category</label>
        <select class="form-control" id="category">
            <option>Notebook</option>
            <option>Camera Body</option>
            <option>Camera Lens</option>
            <option>Smartphone</option>
            <option>Tablet computer</option>
        </select>
    </div>
    <div class="form-group">
        <label for="purchasePrice">Purchase Price</label>
        <input type="number" class="form-control" name="purchasePrice" min="0.00" step="0.01">
    </div>
    <div class="form-group">
        <label for="purchaseDate">Purchase Date</label>
        <input type="date" class="form-control" name="purchaseDate">
    </div>
    <div class="form-group">
        <label for="purchasedFrom">Purchased From</label>
        <input type="text" class="form-control" name="purchasedPlace">
    </div>
    <div class="form-group">
        <label for="uploadReceipt">Upload Receipt</label>
        <input type="file" class="form-control" name="uploadReceipt">
    </div>
    <button type="submit" class="btn btn-default">Add Device</button>
</form>

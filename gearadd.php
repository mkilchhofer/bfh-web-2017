<?php
require_once ('constants.php');
?>

<h3>Add new device</h3>

<form>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name">
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
        <input type="number" class="form-control" id="purchasePrice">
    </div>
    <div class="form-group">
        <label for="purchaseDate">Purchase Date</label>
        <input type="date" class="form-control" id="purchaseDate">
    </div>
    <div class="form-group">
        <label for="purchasedFrom">Purchased From</label>
        <input type="text" class="form-control" id="purchasedFrom">
    </div>
    <div class="form-group">
        <label for="uploadReceipt">Upload Receipt</label>
        <input type="file" class="form-control" id="uploadReceipt">
    </div>
    <button type="submit" class="btn btn-default">Add Device</button>
</form>

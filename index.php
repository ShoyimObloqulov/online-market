<?php

session_start();

if (!isset($_SESSION['logged_in'])) {
    $nav = 'includes/nav.php';
} else {
    $nav = 'includes/navconnected.php';
    $idsess = $_SESSION['id'];
}

require 'includes/header.php';
require $nav; ?>

<style>
    .autocomplete {
        /*the container must be positioned relative:*/
        position: relative;
        display: block;

    }

    .autocomplete-items {
        color: #26a69a;
        font: 16px Roboto, sans-serif;
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding-bottom: 20px;
        padding-top: 20px;
        padding-left: 30px;
        cursor: pointer;
        background-color: #fff;
    }

    .autocomplete-items div:hover {
        /*when hovering an item:*/
        color: #26a69a;
        background-color: #e9e9e9;
    }

    .autocomplete-active {
        /*when navigating through the items using the arrow keys:*/
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
</style>

<div class="container-fluid home" id="top">
    <div class="container search">
        <nav class="animated slideInUp wow">
            <div class="nav-wrapper">
                <form method="GET" action="search.php">
                    <div class="input-field">
                        <input id="search" class="searching" type="search" name='searched' required>
                        <label for="search"><i class="material-icons">search</i></label>
                    </div>

                    <div class="center-align">
                        <button type="submit" name="search" class="blue waves-light miaw waves-effect btn hide">Search</button>
                    </div>
                </form>
            </div>
        </nav>
    </div>
</div>

<div class="container most">
    <div class="row">
        <?php

        include 'db.php';

        // selecting product available in largest quantity
        $queryfirst = "SELECT
    product.id as 'id',
    product.name as 'name',
    product.price as 'price',
    product.thumbnail as 'thumbnail',
    
    SUM(command.quantity) as 'total',
    command.statut,
    command.id_product
    
    FROM product, command
    WHERE product.id = command.id_product AND command.statut = 'paid'
    GROUP BY product.id
    ORDER BY SUM(command.quantity) DESC LIMIT 6";
        $resultfirst = $connection->query($queryfirst);
        if ($resultfirst->num_rows > 0) {
            // output data of each row
            while ($rowfirst = $resultfirst->fetch_assoc()) {

                $id_best = $rowfirst['id'];
                $name_best = $rowfirst['name'];
                $price_best = $rowfirst['price'];
                $thumbnail_best = $rowfirst['thumbnail'];
                $totalsold = $rowfirst['total'];

        ?>

                <div class="col s12 m4">
                    <div class="card hoverable animated slideInUp wow">
                        <div class="card-image">
                            <a href="product.php?id=<?= $id_best;  ?>"><img src="products/<?= $thumbnail_best; ?>"></a>
                            <span class="card-title blue-text"><?= $name_best; ?></span>
                            <a href="product.php?id=<?= $id_best; ?>" class="btn-floating blue halfway-fab waves-effect waves-light right"><i class="material-icons">add</i></a>
                        </div>
                        <div class="card-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col s6">
                                        <p class="white-text"><i class="left fa fa-dollar"></i> <?= $price_best; ?></p>
                                    </div>
                                    <div class="col s6">
                                        <p class="white-text"><i class="left fa fa-shopping-basket"></i> <?= $totalsold; ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
        <?php }
        } ?>


    </div>
</div>

<div class="container-fluid center-align categories">
    <a href="#category" class="button-rounded btn-large waves-effect waves-light">Categories</a>
    <div class="container" id="category">
        <div class="row">
            <?php

            //get categories
            $querycategory = "SELECT id, name, icon  FROM category";
            $total = $connection->query($querycategory);
            if ($total->num_rows > 0) {
                // output data of each row
                while ($rowcategory = $total->fetch_assoc()) {
                    $id_category = $rowcategory['id'];
                    $name_category = $rowcategory['name'];
                    $icon_category = $rowcategory['icon'];

            ?>

                    <div class="col s12 m4">
                        <div class="card hoverable animated slideInUp wow">
                            <div class="card-image">
                                <a href="category.php?id=<?= $id_category; ?>"><img src="src/img/<?= $icon_category; ?>.png" alt=""></a>
                                <span class="card-title black-text"><?= $name_category; ?></span>
                            </div>
                        </div>
                    </div>

            <?php }
            } ?>
        </div>
    </div>
</div>

<?php
require 'includes/secondfooter.php';
require 'includes/footer.php'; ?>
<script>
    var submitButton = document.getElementById("submit_form");
    var form = document.getElementById("email_form");
    form.addEventListener("submit", function(e) {
        setTimeout(function() {
            submitButton.value = "Sending...";
            submitButton.disabled = true;
        }, 1);
    });
</script>
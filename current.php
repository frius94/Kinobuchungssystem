<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aktuell im Kino</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
    <a class="navbar-brand" href="index.php">Kino</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="current.php">Aktuell im Kino</a>
            <a class="nav-item nav-link" href="soon.php">Demnächst im Kino</a>
            <a class="nav-item nav-link" href="reservation.php">Reservation suchen</a>
            <a class="nav-item nav-link" href="info.php">Kinoinfos</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="col">
        <?php

        for ($i = 0; $i < 3; $i++) {
            echo "
            <div class=\"row\">
            <div class=\"card-deck\">
                <div class=\"card\">
                    <img src=\"https://via.placeholder.com/150\" class=\"card-img-top\" alt=\"...\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">Card title</h5>
                        <p class=\"card-text\">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class=\"card-text\"><small class=\"text-muted\">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class=\"card\">
                    <img src=\"https://via.placeholder.com/150\" class=\"card-img-top\" alt=\"...\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">Card title</h5>
                        <p class=\"card-text\">This card has supporting text below as a natural lead-in to additional content.</p>
                        <p class=\"card-text\"><small class=\"text-muted\">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class=\"card\">
                    <img src=\"https://via.placeholder.com/150\" class=\"card-img-top\" alt=\"...\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">Card title</h5>
                        <p class=\"card-text\">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                        <p class=\"card-text\"><small class=\"text-muted\">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
            ";
        }
        ?>

    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
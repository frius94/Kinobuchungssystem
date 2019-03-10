<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aktuell im Kino</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
    <a class="navbar-brand" href="index.php">Kino</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="current.php">Aktuell im Kino</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="col">
        <?php
        require 'Movie.php';
        $dbdata = json_decode(file_get_contents("dbdata.json"), true);

        define("APIKEY", file_get_contents("apikey.txt"));
        define("HOST", $dbdata['host']);
        define("USERNAME", $dbdata['username']);
        define("PASSWORD", $dbdata['pw']);
        define("DBNAME", $dbdata['dbname']);

        $mysqli = new mysqli("127.0.0.1", "root", "2851", "danie298_kinobuchung");
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
        list($movies, $movieTitles) = Movie::getMovies(['Harry Potter', 'Hunger games', 'Thor', 'Spider-man', 'Transformers', 'It', 'The matrix', 'Finding nemo', 'Toy story']);
        for ($i = 0; $i < count($movies); $i++) {
            $dateTime = DateTime::createFromFormat("d M Y", $movies[$i]->getReleased());
            $sql = "INSERT IGNORE INTO `movie` (title, year, released, runtime, genre, plot, language) VALUES ('". $movies[$i]->getTitle() . "', " . $movies[$i]->getYear().", '" . $dateTime->format('Y-m-d') . "', '". $movies[$i]->getRuntime()."', '".$movies[$i]->getGenre()."', '" . addslashes($movies[$i]->getPlot())."', '" . $movies[$i]->getLanguage()."')";
            $mysqli->query($sql);

            if ($i % 3 == 0) {
                echo "<div class=\"row\">
            <div class=\"card-deck mb-5\">";
            }
            echo "<div class=\"card text-white\" id='$movieTitles[$i]' onclick='showRooms(this)' onmouseleave='showInfo(this)'>
                    <img src=\"media/" . $movieTitles[$i] . ".jpg" . "\" class=\"card-img-top\" alt=\"...\">
                    <div class='card-img-overlay ovl'>
                    <div class=\"card-body\">
                        <h5 class=\"card-title scaleTitle\">" . $movies[$i]->getTitle() . "</h5>
                       <p class='card-text font-weight-bold mb-0 scale'>Veröffentlichung</p><p class='scale'>" . $movies[$i]->getReleased() . "</p>
                       <p class='card-text font-weight-bold mb-0 scale'>Dauer</p><p class='scale'>" . $movies[$i]->getRuntime() . "</p>
                       <p class='card-text font-weight-bold mb-0 scale'>Genre</p><p class='scale'>" . $movies[$i]->getGenre() . "</p>
                       <p class='card-text font-weight-bold mb-0 scale'>Regisseur</p><p class='scale'>" . $movies[$i]->getDirector() . "</p>
                       <p class='card-text font-weight-bold mb-0 scale'>Schauspieler</p><p class='scale'>" . $movies[$i]->getActors() . "</p>
                    </div>
                    
                    <div class=\"list-group d-none\">
                        <h5 class='card-title scaleTitle'>Wählen Sie einen Raum aus.</h5>
                        <a href=\"http://localhost/reservation.php?name=" . urlencode($movieTitles[$i]) . "&room=1\" class=\"list-group-item list-group-item-action list-group-item-secondary\">Raum 1  <p class='d-inline ml-5'>verfügbare Plätze:</p> 
                            <span class=\"badge badge-primary badge-pill float-right\">10</span></a>
                        <a href=\"http://localhost/reservation.php?name=" . urlencode($movieTitles[$i]) . "&room=1\" class=\"list-group-item list-group-item-action list-group-item-secondary\">Raum 2  <p class='d-inline ml-5'>verfügbare Plätze:</p> 
                            <span class=\"badge badge-primary badge-pill\">12</span></a></a>
                        <a href=\"http://localhost/reservation.php?name=" . urlencode($movieTitles[$i]) . "&room=1\" class=\"list-group-item list-group-item-action list-group-item-secondary\">Raum 3  <p class='d-inline ml-5'>verfügbare Plätze:</p> 
                            <span class=\"badge badge-primary badge-pill\">3</span></a></a>
                        <a href=\"http://localhost/reservation.php?name=" . urlencode($movieTitles[$i]) . "&room=1\" class=\"list-group-item list-group-item-action list-group-item-secondary\">Raum 4  <p class='d-inline ml-5'>verfügbare Plätze:</p>  
                            <span class=\"badge badge-primary badge-pill\">6</span></a></a>
                    </div>
                    
                    </div>
                </div>";
            if (($i + 1) % 3 == 0) {
                echo "</div>
        </div>";
            }
        }
        $mysqli->close();

        ?>
    </div>
</div>
</body>
<script>
    function showRooms(movie) {
        $(movie).find(".card-body").addClass("d-none");
        $(movie).find(".list-group").removeClass("d-none");
    }

    function showInfo(movie) {
        $(movie).find(".list-group").addClass("d-none");
        $(movie).find(".card-body").removeClass("d-none");
    }

    function reserve(movie) {
        // $(".card-body").addClass("d-none");
        // $(".list-group").removeClass("d-none");
        window.open("http://localhost/reservation.php?name=" + encodeURI($(movie).attr('id')), "_self");
    }
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</html>
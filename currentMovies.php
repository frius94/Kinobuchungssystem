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
            <a class="nav-item nav-link active" href="currentMovies.php">Aktuell im Kino</a>
        </div>
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="myReservation.php">Meine Reservation</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="col">
        <?php

        require 'Movie.php';
        require 'dbQueries.php';

        $mysqli = connectDB();

        list($movies, $movieTitles) = Movie::getMovies(['Harry Potter', 'Hunger games', 'Thor', 'Spider-man', 'Transformers', 'It', 'The matrix', 'Finding nemo', 'Toy story']);

        for ($i = 0; $i < count($movies); $i++) {

            createMovie($mysqli, $movies, $i);

            if ($i % 3 == 0) {
                echo "<div class=\"row\">
            <div class=\"card-deck mb-5\">";
            }

            printMovie($movies, $movieTitles, $i);
            printShow($mysqli, $movies, $movieTitles, $i);

            if (($i + 1) % 3 == 0) {
                echo "</div></div>";
            }
        }
        createRooms($mysqli);
        createSeats($mysqli);
        $mysqli->close();
        ?>
    </div>
</div>
</body>
<script>
    /**
     * Show every available show for the according movie
     * @param movie
     */
    function showShows(movie) {
        $(movie).find(".card-body").addClass("d-none");
        $(movie).find(".list-group").removeClass("d-none");
    }

    /**
     * Show information about the according movie
     * @param movie
     */
    function showInfo(movie) {
        $(movie).find(".list-group").addClass("d-none");
        $(movie).find(".card-body").removeClass("d-none");
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
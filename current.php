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
            <a class="nav-item nav-link" href="soon.php">Demnächst im Kino</a>
            <a class="nav-item nav-link" href="reservation.php">Reservation</a>
            <a class="nav-item nav-link" href="info.php">Kinoinfos</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="col">
        <?php
        require 'Movie.php';
        const APIKEY = "";
        $movies = array();
        $movieTitles = ['Harry Potter', 'Hunger games', 'Thor', 'Spider-man', 'Transformers', 'It', 'The matrix', 'Finding nemo', 'Toy story'];
        foreach ($movieTitles as $movieTitle) {
            $movie = file_get_contents("http://www.omdbapi.com/?t=" . urlencode($movieTitle) . "&plot=full&apikey=" . APIKEY);
            $movie = json_decode($movie, true);
            $movies[] = new Movie($movie['Title'], $movie['Year'], $movie['Released'], $movie['Runtime'], $movie['Genre'], $movie['Director'], $movie['Actors'], $movie['Plot'], $movie['Language'], $movie['Country']);
        }

        for ($i = 0; $i < count($movies); $i++) {
            if ($i % 3 == 0) {
                echo "<div class=\"row\">
            <div class=\"card-deck mb-5\">";
            }
            echo "<div class=\"card text-white\" id='$movieTitles[$i]' onclick='reserve(this)'>
                    <img src=\"media/" . $movieTitles[$i] . ".jpg" . "\" class=\"card-img-top\" alt=\"...\">
                    <div class='card-img-overlay ovl'>
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">" . $movies[$i]->getTitle() . "</h5>
                       <p class='card-text'>Veröffentlichung<br>" . $movies[$i]->getReleased() . "</p>
                       <p class='card-text'>Dauer<br>" . $movies[$i]->getRuntime() . "</p>
                       <p class='card-text'>Genre<br>" . $movies[$i]->getGenre() . "</p>
                       <p class='card-text'>Regisseur<br>" . $movies[$i]->getDirector() . "</p>
                       <p class='card-text'>Schauspieler<br>" . $movies[$i]->getActors() . "</p>
                    </div>
                    </div>
                </div>";
            if (($i + 1) % 3 == 0) {
                echo "</div>
        </div>";
            }
        }
        ?>
    </div>
</div>
</body>
<script>
    function reserve(movie) {
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
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
            <a class="nav-item nav-link" href="currentMovies.php">Aktuell im Kino</a>
        </div>
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="myReservation.php">Meine Reservation</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="jumbotron bg-dark mt-4">
        <h1 class="display-3 text-white">Meine Reservation</h1>
        <p class="lead text-white">Hier können Sie mithilfe Ihrer Reservationsnummer, Informationen bezüglich Ihrer
            Reservation abrufen.</p>
        <form accept-charset="UTF-8" action="" method="GET">
            <div class="form-group">
                <input type="number" class="form-control" id="reservationId" name="reservationId"
                       placeholder="Reservationsnummer">
                <small class="form-text text-muted">Ihre Reservationsnummer befindet sich im Mail, welches wir Ihnen
                    nach der Reservation geschickt haben.
                </small>
            </div>
            <button type="submit" class="btn btn-primary">absenden</button>
        </form>
        <?php
        require 'queryMethods.php';
        if (isset($_GET['reservationId']) && filter_var($_GET['reservationId'], FILTER_SANITIZE_NUMBER_INT)) {

            $reservationId = filter_var($_GET['reservationId'], FILTER_SANITIZE_NUMBER_INT);

            $mysqli = connectDB();

            $getReservationQuery = "SELECT * FROM danie298_kinobuchung.show INNER JOIN reservation ON reservation.show_idshow = danie298_kinobuchung.show.idshow WHERE reservation.idreservation = $reservationId;";
            $reservation = $mysqli->query($getReservationQuery)->fetch_assoc();

            if ($reservation) {
                $movieId = $reservation['movie_idmovie'];
                $movieQuery = "SELECT title FROM movie WHERE idmovie = $movieId;";
                $movie = $mysqli->query($movieQuery)->fetch_assoc();

                $price = $reservation['price'];
                $time = $reservation['time'];
                $room = $reservation['room_idroom'];
                $title = $movie['title'];

                $getSeatsQuery = "SELECT seatnumber, row_letter FROM seat WHERE idseat IN (SELECT seat_idseat FROM reserved_seats WHERE reservation_idreservation = $reservationId);";
                $seats = $mysqli->query($getSeatsQuery)->fetch_all();

                echo "<table class=\"table table-striped table-dark mt-5\">
  <thead>
    <tr>
      <th scope=\"col\">Film</th>
      <th scope=\"col\">Datum &amp; Zeit</th>
      <th scope=\"col\">Preis</th>
      <th scope=\"col\">Raum</th>
      <th scope=\"col\">Sitze</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>$title</td>
      <td>$time</td>
      <td>$price</td>
      <td>$room</td><td>";
                foreach ($seats as $seat) {
                    echo $seat[1] . $seat[0] . ", ";
                }
                echo "</td>
    </tr>
  </tbody>
</table>";

            } else {
                echo "<p class='text-white mt-5'>Ihre Reservation konnte nicht gefunden werden.</p>";
            }
        }
        ?>

    </div>
</div>
</body>
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
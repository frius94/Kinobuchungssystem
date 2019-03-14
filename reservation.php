<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            <a class="nav-item nav-link" href="current.php">Aktuell im Kino</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-4 ml-1">
            <h5 class="mb-4">Bitte wählen Sie Ihre Sitze aus und geben Ihre Daten ein.</h5>
            <form class="mr-auto" accept-charset="UTF-8" method="POST" action="makeReservation.php">
                <div class="form-group">
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Vorname"
                           required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nachname"
                           required>
                </div>
                <div class="form-row">
                    <div class="col-9">
                        <div class="form-group">
                            <input type="text" class="form-control" id="street" name="street" placeholder="Strasse"
                                   required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input type="number" class="form-control" id="number" name="number" placeholder="Nr."
                                   required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" required>
                </div>
                <div class="form-group">
                    <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Telefon" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="movie" name="movie" placeholder="Film"
                           value="<?= $_GET['name'] ?>"
                           required disabled>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="room" name="room" placeholder="Raum"
                           value="Raum: <?= $_GET['room'] ?>" required disabled>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="seats" placeholder="ausgewählte Sitze" required
                           disabled>
                </div>
                <input type="hidden" name="showid" value="<?= $_GET['showid'] ?>">
                <input type="hidden" name="seats" id="hiddenSeats" value="">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Sitze reservieren</button>
            </form>
        </div>

        <div class="col-7 ml-auto mr-4">
            <table class="table table-bordered text-center">
                <thead>
                <tr>
                    <th scope="col">Reihe</th>
                    <th scope="col" colspan="11">Leinwand</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $mysqli = connectDB();

                $countSeatsQuery = "SELECT count(seat.idseat) FROM seat INNER JOIN danie298_kinobuchung.row ON danie298_kinobuchung.row.idrow = seat.row_idrow INNER JOIN room ON room.idroom = danie298_kinobuchung.row.room_idroom WHERE room.idroom = " . $_GET['room'] . ";";
                $countSeats = $mysqli->query($countSeatsQuery);
                $countSeats = $countSeats->fetch_array()[0];

                foreach (range('A', 'F') as $c) {
                    echo "<tr>
        <th class='align-middle'>$c</th>";
                    for ($seatNumber = 1; $seatNumber <= 10; $seatNumber++) {
                        $seatOccupiedQuery = "SELECT seat.occupied FROM seat INNER JOIN danie298_kinobuchung.row ON danie298_kinobuchung.row.idrow = seat.row_idrow INNER JOIN room ON room.idroom = danie298_kinobuchung.row.room_idroom INNER JOIN danie298_kinobuchung.show ON show.room_idroom = room.idroom WHERE danie298_kinobuchung.show.idshow = " . $_GET['showid'] . " AND danie298_kinobuchung.row.row_letter = '" . $c . "' AND seat.seatnumber = " . $seatNumber . ";";
                        $occupied = $mysqli->query($seatOccupiedQuery);
                        $occupied = $occupied->fetch_array();
                        $id = $c . $seatNumber;
                        if ($occupied['occupied']) {
                            echo "<td><a href='#'><img id='$id' src='media/seatGray.png' class='img-fluid' alt='seat' onclick='fillSeat(this)'></a>" . $seatNumber . "</td>";
                        } else {
                            echo "<td><a href='#'><img id='$id' src='media/seatBlack.png' class='img-fluid' alt='seat' onclick='fillSeat(this)'></a>" . $seatNumber . "</td>";
                        }
                    }
                    echo "</tr>";
                }
                $mysqli->close();
                ?>
                </tbody>
            </table>
        </div>
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
<script type="application/javascript">
    var selectedSeats = [];

    function fillSeat(seat) {
        if ($(seat).attr('src') === "media/seatBlack.png") {
            $(seat).attr('src', "media/seatRed.png");
            selectedSeats.push($(seat).attr('id'));
            $('#seats').attr('value', selectedSeats.toString());
            $('#hiddenSeats').attr('value', selectedSeats.toString());
        } else if ($(seat).attr('src') === "media/seatRed.png") {
            $(seat).attr('src', "media/seatBlack.png");
            selectedSeats.splice(selectedSeats.indexOf($(seat).attr('id')), 1);
            $('#seats').attr('value', selectedSeats.toString());
            $('#hiddenSeats').attr('value', selectedSeats.toString());
        }
    }
</script>
</html>
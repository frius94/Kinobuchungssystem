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
            <a class="nav-item nav-link" href="currentMovies.php">Aktuell im Kino</a>
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
                <div class="form-row">
                    <div class="col-9">
                        <div class="form-group">
                            <input type="text" class="form-control" id="city" name="city" placeholder="Stadt"
                                   required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input type="text" class="form-control" id="zip" name="zip" placeholder="PLZ"
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
                           value="<?php
                           echo htmlspecialchars($_GET['name']);
                           ?>"
                           required disabled>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="room" name="room" placeholder="Raum"
                           value="Raum: <?php
                           echo htmlspecialchars($_GET['room']);
                           ?>" required disabled>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="seats" placeholder="ausgewählte Sitze" required
                           disabled>
                </div>
                <input type="hidden" name="showid" value="<?php
                echo htmlspecialchars($_GET['showid']);
                ?>">
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
                require 'dbQueries.php';

                $mysqli = connectDB();
                printSeats($mysqli);
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
    var selectedSeatIds = [];

    /**
     * If the clicked seat is black, turn it to red (selected)
     * If the clicked seat is red, turn it to black (not selected)
     * @param seat
     */
    function fillSeat(seat) {
        if ($(seat).attr('src') === "media/seatBlack.png") {
            $(seat).attr('src', "media/seatRed.png");
            selectedSeats.push($(seat).attr('id'));
            selectedSeatIds.push($(seat).attr('alt'));
            $('#seats').attr('value', selectedSeats.toString());
            $('#hiddenSeats').attr('value', selectedSeatIds.toString());
        } else if ($(seat).attr('src') === "media/seatRed.png") {
            $(seat).attr('src', "media/seatBlack.png");
            selectedSeats.splice(selectedSeats.indexOf($(seat).attr('id')), 1);
            selectedSeatIds.splice(selectedSeatIds.indexOf($(seat).attr('alt')), 1);
            $('#seats').attr('value', selectedSeats.toString());
            $('#hiddenSeats').attr('value', selectedSeatIds.toString());
        }
    }
</script>
</html>
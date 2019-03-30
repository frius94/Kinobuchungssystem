<?php

require 'queryMethods.php';
if (isset($_POST['reservationId']) && filter_var($_POST['email'], FILTER_SANITIZE_NUMBER_INT)) {

    $reservationId = filter_var($_POST['firstname'], FILTER_SANITIZE_NUMBER_INT);

    $mysqli = connectDB();

    $getReservationQuery = "SELECT * FROM danie298_kinobuchung.show INNER JOIN reservation ON reservation.show_idshow = danie298_kinobuchung.show.idshow WHERE reservation.idreservation = $reservationId;" ;

    $reservation = $mysqli->query($getReservationQuery);

    if ($reservation) {
        $reservation = $reservation->fetch_assoc();
        var_dump($reservation);
    }
}
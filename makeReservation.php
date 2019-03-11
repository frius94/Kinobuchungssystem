<?php
/**
 * Created by PhpStorm.
 * User: Umut
 * Date: 11.03.2019
 * Time: 01:13
 */
if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['street']) && isset($_POST['number']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['seats']) && isset($_POST['showid'])) {

    $mysqli = new mysqli("127.0.0.1", "root", "2851", "danie298_kinobuchung");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_STRING);
    $movie = filter_var($_POST['movie'], FILTER_SANITIZE_STRING);
    $room = filter_var($_POST['room'], FILTER_SANITIZE_STRING);
    $seats = filter_var($_POST['seats'], FILTER_SANITIZE_STRING);
    $showId = filter_var($_POST['showid'], FILTER_SANITIZE_STRING);


    $insertPerson = "INSERT IGNORE INTO `person`(firstname, lastname, street, number, email, mobile) VALUES ('$firstname', '$lastname', '$street', '$number', '$email', '$mobile')";
    $result = $mysqli->query($insertPerson);

    $personQuery = "SELECT idperson FROM person WHERE firstname = '$firstname' AND lastname = '$lastname' AND mobile = '$mobile'";
    $personId = $mysqli->query($personQuery);
    $personId = $personId->fetch_array()[0];

    $row = substr($seats, 0, 1);
    $seat = substr($seats, 1, 1);

    $reservationSeatQuery = "SELECT idseat FROM seat INNER JOIN danie298_kinobuchung.row ON danie298_kinobuchung.row.idrow = seat.row_idrow INNER JOIN room ON room.idroom = danie298_kinobuchung.row.room_idroom INNER JOIN danie298_kinobuchung.show ON danie298_kinobuchung.show.room_idroom = room.idroom WHERE danie298_kinobuchung.show.idshow = $showId AND danie298_kinobuchung.row.row_letter = '$row' AND seat.seatnumber = $seat;";
    $idseat = $mysqli->query($reservationSeatQuery);
    $idseat = $idseat->fetch_array()[0];

    $insertReservationQuery = "INSERT IGNORE INTO `reservation`(show_idshow, person_idperson, seat_idseat) VALUES ($showId, $personId, $idseat)";
    $res = $mysqli->query($insertReservationQuery);

    $mysqli->close();
    echo "<script>alert('Danke für Ihre Registrierung. Sie war erfolgreich.')</script>";
} else {
    echo "<script>alert('Leider ist bei der Registrierung ein Fehler aufgetreten.')</script>";
}
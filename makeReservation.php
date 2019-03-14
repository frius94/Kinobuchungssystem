<?php
/**
 * Created by PhpStorm.
 * User: Umut
 * Date: 11.03.2019
 * Time: 01:13
 */


if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['street']) && isset($_POST['number']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['seats']) && isset($_POST['showid'])) {

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

    $row = substr($seats, 0, 1);
    $seat = substr($seats, 1, 1);

    $mysqli = connectDB();

    if (insertPerson($mysqli, $firstname, $lastname, $street, $number, $email, $mobile)) {
        $personID = getPersonID($mysqli, $firstname, $lastname, $mobile);
        if (insertReservation($mysqli, $showId, $personID)) {
            updateSeatOccupation($mysqli, $row, $seat);
        }
    }
    $mysqli->close();

    mail($email, "Ihre Kinoreservierung", "Danke für Ihre Kinoreservierung.\n");

    echo "<script>alert('Danke für Ihre Registrierung. Sie war erfolgreich.')</script>";
    header("Location: https://localhost/index.php");
} else {
    echo "<script>alert('Leider ist bei der Registrierung ein Fehler aufgetreten.')</script>";
    header("Location: https://localhost/index.php");
}

/**
 * @param mysqli $mysqli
 * @param $firstname
 * @param $lastname
 * @param $street
 * @param $number
 * @param $email
 * @param $mobile
 * @return bool|mysqli_result
 */
function insertPerson(mysqli $mysqli, $firstname, $lastname, $street, $number, $email, $mobile)
{
    $insertPerson = "INSERT IGNORE INTO `person`(firstname, lastname, street, number, email, mobile) VALUES ('$firstname', '$lastname', '$street', '$number', '$email', '$mobile');";
    return $mysqli->query($insertPerson);
}

/**
 * @param mysqli $mysqli
 * @param $firstname
 * @param $lastname
 * @param $mobile
 * @return mixed
 */
function getPersonID(mysqli $mysqli, $firstname, $lastname, $mobile)
{
    $personQuery = "SELECT idperson FROM person WHERE firstname = '$firstname' AND lastname = '$lastname' AND mobile = '$mobile';";
    $personId = $mysqli->query($personQuery);
    return $personId->fetch_array()[0];
}

/**
 * @param mysqli $mysqli
 * @param $showId
 * @param $personId
 * @return bool|mysqli_result
 */
function insertReservation(mysqli $mysqli, $showId, $personId)
{
    $insertReservationQuery = "INSERT IGNORE INTO `reservation`(show_idshow, person_idperson) VALUES ($showId, $personId);";
    return $mysqli->query($insertReservationQuery);
}

/**
 * @param mysqli $mysqli
 * @param $row
 * @param $seat
 * @return bool|mysqli_result
 */
function updateSeatOccupation(mysqli $mysqli, $row, $seat)
{
    $insertSeatOccupationQuery = "UPDATE seat INNER JOIN danie298_kinobuchung.row AS r ON r.idrow = seat.row_idrow INNER JOIN room ON room.idroom = r.room_idroom INNER JOIN danie298_kinobuchung.show AS s ON s.room_idroom = room.idroom SET occupied = 1 WHERE s.idshow = 1 && r.row_letter = '$row' && seat.seatnumber = $seat;";
    return $mysqli->query($insertSeatOccupationQuery);
}

/**
 * @return mysqli
 */
function connectDB()
{
    $mysqli = new mysqli("127.0.0.1", "root", "2851", "danie298_kinobuchung");
    if ($mysqli->connect_error) {
        die("Es konnte keine Verbindung zur Datenbank hergestellt werden. Bitte kontaktieren Sie unseren Support unter +41786041237\n" . $mysqli->connect_error);
    }
    return $mysqli;
}
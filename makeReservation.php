<?php

require 'dbQueries.php';
if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['street']) && isset($_POST['number']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['seats']) && isset($_POST['showid']) && isset($_POST['city']) && isset($_POST['zip'])) {

    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_STRING);
    $seats = filter_var($_POST['seats'], FILTER_SANITIZE_STRING);
    $showId = filter_var($_POST['showid'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $zip = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);


    $seatsArray = explode(",", $seats);

    $mysqli = connectDB();
    $idCity = insertCity($mysqli, $city, $zip);
    insertPerson($mysqli, $firstname, $lastname, $street, $number, $email, $mobile, $idCity);
    $personId = getPersonID($mysqli, $firstname, $lastname, $mobile);
    insertReservation($mysqli, $showId, $personId);
    $reservationId = getReservationID($mysqli);
    insertReservedSeats($mysqli, $seatsArray, $reservationId);
    $mysqli->close();

    mail($email, "Ihre Kinoreservierung", "Danke für Ihre Kinoreservierung. Ihre Reservierungsnummer lautet $reservationId.\nUnter https://kinobuchung.ch/getReservation.php können Sie Informationen zu Ihrer Reservierung abrufen.\nFreundliche Grüsse\nIhr Kinobuchung.ch Team", "From: Kinobuchung.ch <noreply@kinobuchung.ch>");

    echo "<script>alert('Danke für Ihre Registrierung. Sie war erfolgreich.');
                  window.location.href = 'https://kinobuchung.ch/index.php';
          </script>";
} else {
    echo "<script>alert('Leider ist bei der Registrierung ein Fehler aufgetreten.');
                  window.location.href = 'https://kinobuchung.ch/index.php';
          </script>";
}

/**
 * Insert person to database with data from the inputFields
 * @param mysqli $mysqli
 * @param $firstname
 * @param $lastname
 * @param $street
 * @param $number
 * @param $email
 * @param $mobile
 * @return bool|mysqli_result
 */
function insertPerson(mysqli $mysqli, $firstname, $lastname, $street, $number, $email, $mobile, $idCity)
{
    $insertPerson = "INSERT IGNORE INTO `person`(firstname, lastname, street, number, email, mobile, city_idcity) VALUES ('$firstname', '$lastname', '$street', '$number', '$email', '$mobile', $idCity);";
    return $mysqli->query($insertPerson);
}

/**
 * Insert city to database with data from the inputFields
 * @param mysqli $mysqli
 * @param $name
 * @param $zip
 * @return mixed
 */
function insertCity(mysqli $mysqli, $name, $zip)
{
    $insertCity = "INSERT ignore INTO `city`(name, zip) VALUES ('$name', '$zip');";
    $mysqli->query($insertCity);
    $getId = "SELECT idcity FROM city WHERE name = '$name' and zip = '$zip';";
    return $mysqli->query($getId)->fetch_assoc()['idcity'];
}

/**
 * Get the person ID from database. Search for the person with the same lastname and mobile number.
 * @param mysqli $mysqli
 * @param $firstname
 * @param $lastname
 * @param $mobile
 * @return int
 */
function getPersonID(mysqli $mysqli, $firstname, $lastname, $mobile): int
{
    $personQuery = "SELECT idperson FROM person WHERE firstname = '$firstname' AND lastname = '$lastname' AND mobile = '$mobile';";
    $personId = $mysqli->query($personQuery)->fetch_assoc()['idperson'];
    return $personId;
}

/**
 * Insert a new reservation to database
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
 * Get the reservation ID from database with call of the mysql last_insert function which returns the id from the last insert
 * @param mysqli $mysqli
 * @return mixed
 */
function getReservationID(mysqli $mysqli)
{
    $reservationQuery = "SELECT LAST_INSERT_ID();";
    return $mysqli->query($reservationQuery)->fetch_assoc()['LAST_INSERT_ID()'];
}

/**
 * Insert the reserved seats to the database with the reservation ID and the seat IDs in an array
 * @param mysqli $mysqli
 * @param $seatIds
 * @param $reservationId
 * @return bool|mysqli_result
 */
function insertReservedSeats(mysqli $mysqli, $seatIds, $reservationId)
{
    foreach ($seatIds as $seatId) {
        $reservedSeatQuery = "INSERT INTO reserved_seats VALUES ($reservationId, $seatId);";
        $result = $mysqli->query($reservedSeatQuery);
    }
    return $result;
}
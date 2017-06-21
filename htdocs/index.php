<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$patientName = $_POST["patientName"];
$dob = $_POST["dob"];
$prescription = $_POST["prescription"];
$dose = $_POST["dose"];
$doseDays = $_POST["doseDays"];
$doseTime = $_POST["doseTime"];
$contact = $_POST["contact"];
$contactMethod = $_POST["contactMethod"];

function addToDb() {
  class Result {
    public $status;
    public $details;

    public function __construct($status, $details) {
      $this->status = $status;
      $this->details = $details;
    }
  }


  global $patientName, $dob, $prescription, $dose, $doseDays, $doseTime, $contact, $contactMethod;
  $serverName = 'localhost';
  $dbUserName = 'root';
  $dbUserPass = '275229946s';
  $dbName = 'dyspense';

  $conn = new mysqli($serverName, $dbUserName, $dbUserPass, $dbName);
  if ($conn->connect_error) return new Result('failed', $conn->connect_error);


  if (!($conn->query('CREATE TABLE IF NOT EXISTS patients (Name TEXT NOT NULL, DOB DATE, `Dosage (mg)` TEXT, `Dose Day` TEXT, `Dose Time` TIME, `Pill Color` TEXT, `Contact Info` TEXT, `Contact Method` INT)'))) {
    $conn->close();
    return new Result('failed', "Table creation failed: (" . $conn->errno . ") " . $conn->error);
  }


	if (!($stmt = $conn->prepare("INSERT INTO patients (Name, DOB, `Dosage (mg)`, `Dose Day`, `Dose Time`, `Pill Color`, `Contact Info`, `Contact Method`) VALUES (?, ?, ?, ?, ?, ? ,?, ?)"))) {
		$conn->close();
		return new Result('failed', "Insert Prepare failed: (" . $conn->errno . ") " . $conn->error);
	}

	if (!($stmt->bind_param("ssissssi", $patientName, $dob, $dose, $doseDays, $doseTime, $prescription, $contact, $contactMethod))) {
		$stmt->close();
		$conn->close();
		return new Result('failed', "Insert Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}

  if (!($stmt->execute())) {
    $stmt->close();
    $conn->close();
    return new Result('failed', "Insert/Update Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }

  $stmt->close();
  $conn->close();

  return new Result('success', NULL);
}

$results = addToDb();

if ($results->status == 'success') echo 'success';
else echo $results->details;

?>

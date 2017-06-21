<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

function addToDb() {
  class Result {
    public $status;
    public $details;

    public function __construct($status, $details) {
      $this->status = $status;
      $this->details = $details;
    }
  }

  $serverName = 'localhost';
  $dbUserName = 'root';
  $dbUserPass = '275229946s';
  $dbName = 'dyspense';
  $confirmed = 0;

  $conn = new mysqli($serverName, $dbUserName, $dbUserPass, $dbName);
  if ($conn->connect_error) return new Result('failed', $conn->connect_error);

  if (!($result = $conn->query('SELECT * FROM patients'))) {
    $conn->close();
    return new Result('failed', "Select failed: (" . $conn->errno . ") " . $conn->error);
  }
  if ($result->num_rows < 1) {
    return new Result('empty', NULL);
  }
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $tableData .= '<tr><td><div style="float: left"><img src="generic.png" style="margin-right: 10px;" class="selfie icon" height="60px" width="50px"></div><p style="float: right"><ul><li>   Name:<br><b>' . $row["Name"] . '</b></li><li>   Date of Birth: <b>' . $row["DOB"] . '</b></li></ul></p></td></tr>';
    }
  }


  $conn->close();
  return new Result('success', $tableData);
}

$results = addToDb();

if ($results->status == 'success' || $results->status == 'failed') echo $results->details;
else echo 'No pending registrations found.';


?>

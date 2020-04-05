<?php
/* 
 *      Customer Counter App
 *      Author: Steve Cumming - April 2020
 *
 *      Page: functions.php
 *      Assortment of functions supporting other elements of the application
 *      A lot of it is validation, error reporting, and logging.
 */
?>

<?php
require_once("conn.php");       // MySQL connection object


function checkLimits($store_num) {
    // Fetches the three customer limits for a particular store
    $conn = mySQLconnection();
    $sql = "SELECT min, recommended, max FROM counts WHERE store = " . $store_num;
    $result = $conn->query($sql);

    $limits = array();
    $limits["min"] = 0;
    $limits["recommended"] = 0;
    $limits["max"] = 0;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $limits["min"]          = $row["min"];
            $limits["recommended"]  = $row["recommended"];
            $limits["max"]          = $row["max"];
        }
    }
    else {
        echo "ERROR [16]";
    }
    $conn->close();

    return $limits;
}



function getUserIpAddr(){
    /*
     *  Function that returns the user's current IP address
     *  Used for logging and possibility of blacklisting
     */
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


function myRecordVisit($store_num) {
    $conn = mySQLconnection();
	$sql = "INSERT INTO customercounter.log (store, log.ip)
	VALUES ('" . $_GET["store_num"] . "', '" . getUserIpAddr() . "')";

	if ($conn->query($sql) === TRUE) {
		//echo "New record created successfully";
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	
}



function logError($error_msg) {
    /*
     *  TODO
     *  Logs error to DB and TODO refresh client page w/ error message?
     */
}


function checkValidStore($store_num) {
    // Used to validate store number entered on the front page
    if ($store_num == "") {
        // if it's blank return 0 straight away
        return 0;
    }

    $conn = mySQLconnection();
    $sql = "SELECT count FROM counts WHERE store = " . $store_num;
    $result = $conn->query($sql);

    $return = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $return = 1; // Store is valid flag
        }
    }
    else {
        $return = 2; // Store number is invalid flag
    }
    $conn->close();

    return $return;
}


?>
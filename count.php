<?php
/* 
 *      Customer Counter App
 *      Author: Steve Cumming - April 2020
 *
 *      Page: count.php
 *      Clicker.php's XMLHttpRequest pulls the store's current count from this page.
 *      Used to communicate directly with MySQL database.
 *
 *
 *		TODO: use session storage for store number and sanitise the inputs to prevent injection attacks
 *
 */
?>



<?php
    header("Content-type: text/plain");
    require_once("conn.php");       // MySQL connection object

    $store_num = $_GET["store_num"]; // pull store number from URL
    

    switch ($_GET["req"]) {
        case 'inc':
            incrementCount($store_num);
            break;

        case 'dec':
            decrementCount($store_num);
            break;
        
        default:
            break;
    }

    echo checkCount($store_num); // This line is important.
    // prints the current store's count in plain text to be picked up by clicker.php 's XMLHttpRequest



    function checkCount($store_num) {
        // Fetches the current count for $store_num and returns it.
        $conn = mySQLconnection();
        $sql = "SELECT count FROM counts WHERE store = " . $store_num;
        $result = $conn->query($sql);

        $count = 0;

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $count = $row["count"];
            }
        }
        else {
            echo "ERROR [12]"; // TODO implement more verbose error handling
        }
        $conn->close();

        return $count;
    }

    function incrementCount($store_num) {
        $conn = mySQLconnection();

        // Increment Current Count
        $sql = "UPDATE counts SET count = count + 1 WHERE store = " . $store_num;
        if ($conn->query($sql) === TRUE) {
            // success
        } else {
            echo "ERROR [13]"; // TODO implement more verbose error handling
        }

        // Increment Total_IN Count
        $sql = "UPDATE counts SET total_in = total_in + 1 WHERE store = " . $store_num;
        if ($conn->query($sql) === TRUE) {
            // success
        } else {
            echo "ERROR [13.5]"; // TODO implement more verbose error handling
        }

        // Return back
        $conn->close();
        return true;
    }

    function decrementCount($store_num) {
        $conn = mySQLconnection();

        // Decrement Current Count
        $sql = "UPDATE counts SET count = GREATEST(0, count - 1) WHERE store = " . $store_num;
        if ($conn->query($sql) === TRUE) {
            // success
        } else {
            echo "ERROR [14]"; // TODO implement more verbose error handling
        }

        // Increment Total_OUT count
        $sql = "UPDATE counts SET total_out = total_out + 1 WHERE store = " . $store_num;
        if ($conn->query($sql) === TRUE) {
            // success
        } else {
            echo "ERROR [14.5]"; // TODO implement more verbose error handling
        }

        // Return back
        $conn->close();
        return true;
    }



?>


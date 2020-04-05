<?php
/* 
 *      Customer Counter App
 *      Author: Steve Cumming - April 2020
 *
 *      Page: conn.php
 *      Purely a function to create an sql connection.
 *      It's in it's own file to easily modify the database credentials.
 */
?>

<?php
function mySQLconnection() {
    /*
     *  For establishing the mysql object using the supplied credentials
     *  returns a mysqli object ($conn)
     */
    $servername = "192.168.1.17";
    $dbusername = "customercounter";
    $dbpassword = "doncaster3128";
    $dbname = "customercounter";

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
<?php
/* 
 *      Customer Counter App
 *      Author: Steve Cumming - April 2020
 *
 *      Page: clicker.php
 *      After the store number has been entered display the counter buttons
 *      Indicator status messages (small message under count) are defined here
 *      
 *      This page also handles the bulk of javascript functions.
 *      TIMEOUT FOR DATA REFRESHING IS SET HERE (how often it syncs it's count)
 */
?>

<form>
    <table>
        <tr>
            <td>
                <h3 style="text-align: left;">Store: 
                    <span id="store">
                        <?php echo $_GET["store_num"]; ?></span>
                        <a href="index.php">(change)</a>
                    </span>
                </h3>
            </td>
            <td>
                <h3 style="text-align: right;">
                    Min:
                    <span id="min">
                        <?php echo checkLimits($_GET["store_num"])["min"];?> 
                    </span><br />

                    Recommended: 
                    <span id="recommended">
                        <?php echo checkLimits($_GET["store_num"])["recommended"];?>
                    </span><br />

                    Max: 
                    <span id="max">
                        <?php echo checkLimits($_GET["store_num"])["max"];?>
                    </span>
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="2"><h1 id="myCount"></h1></td>
        </tr>
        <tr>
            <td colspan="2"><h3 id="myStatus"></h3></td>
        </tr>
        <tr>
            <td class="header"><h2 style="color: #00aa00;">IN</h2></td>
            <td class="header"><h2 style="color: #aa0000;">OUT</h2></td>
        </tr>
        <tr>
            <td>
                <img onclick="updateCount('inc')" class="icon" src="../assets/enter.svg" alt="enter"/>
            </td>

            <td>
                <img onclick="updateCount('dec')" class="icon" src="../assets/exit.svg" alt="exit"/>
            </td>
        </tr>

        <tr>
            <td colspan="2"> 

            </td>
        </tr>
    </table>
</form>

<script>
    var readyAgain = true;

    var store = document.getElementById("store").textContent;

    function loadingSpinner() {
        // To style a loading wheel where the count goes
        var spinner = "<div class='loader'>Loading...</div>";
        document.getElementById("myCount").innerHTML = spinner;
    }

    function updateCount(state) {
        readyAgain = false; // set flag
        var xhttp = new XMLHttpRequest();
        var url = "../count.php";


        var params = "store_num=" + store + "&req=" + state + "&t=" + new Date().getTime();

        url = encodeURIComponent(url);

        xhttp.open("GET", url+"?"+params, true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("myCount").innerHTML = this.responseText;
                updateStatus(this.responseText);
                
                readyAgain = true;
            }
        };

    }


    function updateStatus(count) {
        // Function to update the little message below the count.
        var min = Number(document.getElementById("min").innerHTML);
        var recommended = Number(document.getElementById("recommended").innerHTML);
        var max = Number(document.getElementById("max").innerHTML);



        if (count < min) {
            // Below Minimum Allowed Customers

            // Update text under count
            var text = "&nbsp;";
            document.getElementById("myStatus").innerHTML = text;

            // Update colour
            document.getElementById("myStatus").style.color = "#b5ada5"; //grey


        } 
        else if ( count >= min && count < recommended ) {
            // Above minimum but below recommended

            // Update text under count
            var text = "Above Minimum";
            document.getElementById("myStatus").innerHTML = text;

            // Update colour
            document.getElementById("myStatus").style.color = "#b5ada5"; //grey

        } 
        else if ( count >= recommended && count < max ) {
            // Above recommended, below max

            // Update text under count
            var text = "Above Recommended";
            document.getElementById("myStatus").innerHTML = text;

            // Update colour
            document.getElementById("myStatus").style.color = "#aa5500"; //orange
        } 
        else if (count > max) {
            // Above max

            // Update text under count
            var text = "Above Maximum";
            document.getElementById("myStatus").innerHTML = text;

            // Update colour
            document.getElementById("myStatus").style.color = "#aa0000"; //red
        }

    }


    function firstLoad() {
        loadingSpinner();   // Load the loading spinner
        timeout();          // Start timer for fetching
    }


    // Timer function to request data
    function timeout() {
        setTimeout(function () {
            if (readyAgain) { // checks to make sure the previous request was processed
                updateCount();
            }
            timeout();
        }, 2000); // IMPORTANT -> Refresh interval for fetching. Currently 2 seconds.
    }




</script>
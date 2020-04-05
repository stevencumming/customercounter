<?php
/* 
 *      Customer Counter App
 *      Author: Steve Cumming - April 2020
 *
 *      Page: index.php
 *      Index page. Checks store number (after validation)
 * 		Displays relevant elements.
 */
?>

<?php
	require_once("../functions.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=500, initial-scale=0.7">
    <link href="../style.css" rel="stylesheet">
    <title>Customer Counter</title>
    <link rel="icon" 
      type="image/png" 
      href="../assets/crowd.svg">
  </head>


    <?php
    	// Check store number:
    	switch (checkValidStore($_GET["store_num"])) {
    		case 1: // Store number correct:
    			echo "<body onload=\"firstLoad()\">";
				myRecordVisit($_GET["store_num"]);
    			require_once("../clicker.php");
    			break;

    		case 2: // Store number invalid:
    			echo "<body>";
    			require_once("../store_select.php");
    			echo "
					<table>
					    <tr>
					        <th>
					            <h3 class=\"invalid_store\">Please enter a valid store number</h3>
					        </th>
					    </tr>
					</table>";
    			break;
    		
    		default: // or case 0 (nothing entered)
    			echo "<body>";
    			require_once("../store_select.php");
    			break;
    	}

    	
    	
    ?>




    <p id="copy">© Steve Cumming <?php echo date('Y') ?></p>

   


  </body>
</html>
<?php
/* 
 *      Customer Counter App
 *      Author: Steve Cumming - April 2020
 *
 *      Page: store_select.php
 *      Landing page for store selection
 *      Pretty barebones
 */
?>

<form method="get">
<table>
    <tr>
        <td>
            <img class="logo" src="../assets/crowd.svg" />
        </td>
    </tr>
    <tr>
        <td>
            <h1 class="title">Customer Counter</h1>
        </td>
    </tr>
    <tr>
        <td>
            <h2>Enter Store Number:</h2>
        </td>
    </tr>
    <tr>
        <td>
            <input type="number" name="store_num" pattern="\d*"> 
            <!-- the pattern flag forces ios numpad as default -->
        </td>
    </tr>
    <tr>
        <td>
            <input value="Enter" type="submit">
        </td> 
    </tr>
</table>
</form>

<?php
//Datu basera konektatzeko
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

//Konexioa egiaztatu
if(!$conn){
    die("Konexio galduta:" .mysqli_connect_error());
}

//Itemak bistaratzeko 
$query = "SELECT id, izena FROM FunkoPop";
$result = mysqli_query($conn, $query);

//Egiaztatu kontsulta ondo egin dela
if(!$result){
    die("Errorea kontsultan:" .mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Itemak bistaratu</title>
</head>
<body>
    <h1>Funko Pop</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Izena</th>
        </tr>
        <?php
        //taula sortu
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>" .$row['id']. "</td>";
                echo "<td>" .$row['izena']. "</td>";
                echo "<td>";
                //Esteka "show_item.php"-ra birbideratzeko, hautatutako itemaren IDa pasatuz:
                echo "<a href='show_item.php?item=" . $row['id'] . "'>Ikusi xehetasunak</a>"; 
                echo "<a id='item_delete_submit" . $row['id'] . "' href='delete_item.php?item=" . $row["id"] . "' onclick='return confirm(\"Elementu hau ezabatu nahi duzu?\");'>Ezabatu</a>";
                echo "</td>";
                echo "</tr>";
            }
        }
        else{
            echo "<tr><td>Ez dago itemik</td></tr>";
        }
        
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>

  

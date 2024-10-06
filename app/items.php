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
                echo "<form method='get' action='show_item.php'>";
                    echo "<input type='hidden' name='item' value='" . $row['id'] . "'>";
                    echo "<button type='submit'>Ikusi xehetasunak</button>";
                echo "</form>";
                echo "</td>";
                echo "<td>";
                echo "<form method='get' action='delete_item.php'>";
                    echo "<input type='hidden' name='item' value='" . $row['id'] . "'>";
                    echo "<button type='submit'>Ezabatu</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td>Ez dago itemik</td></tr>";
        }
        
        mysqli_close($conn);
        ?>
    </table>
    <form method='post' action='/'>
        <button type='submit'>Hasierara itzuli</button>
    </form>
</body>
</html>

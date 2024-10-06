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

//Formularioa bete ondoren datuak sartu
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bidalita']) && $_POST['bidalita'] == '1'){
    //Lortu datuak
    $id = $_POST['id'];
    $izena = $_POST['izena'];
    $mota = $_POST['mota'];
    $tamaina = $_POST['tamaina'];
    $prezioa = $_POST['prezioa'];

    //ID errepikatuta dagoen egiaztatu
    $query = "SELECT * FROM FunkoPop WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('ID hori duen elementua jada existitzen da.');</script>";
        exit();
    }
    else{
        //Errepikatuta ez badago, elementu berria sartu
        $query = "INSERT INTO FunkoPop (id, izena, mota, tamaina, prezioa) VALUES ('$id', '$izena', '$mota', '$tamaina', '$prezioa')";
        $result = mysqli_query($conn, $query);
        if(!$result){
            die("Errorea kontsultan:" .mysqli_error($conn));
        } 
        else{
            echo "<script>alert('Elementua gehitu da.');</script>";
        }  
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Itemak gehitu</title>
</head>
<body>
    <h1>Itemak gehitu</h1>
    <form name="item_add_form" id="item_add_form" method="POST" action="">
        <label>Id:</label><br>
        <input type="text" name="id"><br>
        <label>Izena:</label><br>
        <input type="text" name="izena"><br>
        <label>Mota:</label><br>
        <input type="text" name="mota"><br>
        <label>Tamaina:</label><br>
        <input type="text" name="tamaina"><br>
        <label>Prezioa:</label><br>
        <input type="text" name="prezioa"><br>
        <input type="button" name="item_add_submit" id="item_add_submit" value="Gehitu" onclick="datuakEgiaztatu()">
        <input type="hidden" name="bidalita" value="0">
    </form>
    <script>
        function datuakEgiaztatu() {
            var id = document.item_add_form.id.value;
            var izena = document.item_add_form.izena.value;
            var mota = document.item_add_form.mota.value;
            var tamaina = document.item_add_form.tamaina.value;
            var prezioa = document.item_add_form.prezioa.value;
            
            if (id == "" || izena == "" ||  mota== "" || tamaina == "" || prezioa == "") {
                window.alert("Zerbait hutsik dago");
            } 

            if(isNaN(id) || id < 0){
                window.alert("Id zenbaki bat izan behar da.");
            }

            if(isNaN(prezioa) || prezioa < 0){
                window.alert("Prezioa zenbaki bat izan behar da.");
            }
            //dena ondo badago formularioa bidali
            document.item_add_form.bidalita.value = '1';
            document.item_add_form.submit();
            
        }
    </script>
</body>
</html>
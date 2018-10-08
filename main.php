<html>
<head>
	<title>Adress Book</title>
</head>
<body>
	<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "address_db";

	$con= new mysqli($host,$user,$pass);
	if($con->connect_error) {
		die("Connection Failed: " .$con->connect_error);
	}

	if($con->select_db($db) == false) {
		$sql = "CREATE DATABASE $db";
		if($con->query($sql)==TRUE) {
			echo "Database Berhasil Dibuat<br>";
		}
		else {
			echo "Error Creating Database: " .$con->error;
		}
	}
	else {
		echo "Database Tersambung<br>";
	}

	$con= new mysqli($host,$user,$pass,$db);

	if($con->query("CREATE TABLE address_book (
					No INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					Name VARCHAR(30) NOT NULL,
					Nick VARCHAR(15) NOT NULL,
					Phone VARCHAR(15) NOT NULL,
					Date TIMESTAMP
					)") === TRUE) {
		echo "Tabel Berhasil Dibuat<br>";
	}
	else {
		echo " <br>";
	}
	
	?>

    <form action="" method="post">
        Input<br />
        Full Name<br /><input type="text" name="name" /><br />
        Nick Name<br /><input type="text" name="nick" /><br />
        Phone<br /><input type="text" name="phone" /><br />
        <input type="submit" value="Add" name="add" />
        
        <input type="submit" value="Show Table" name="show" /><br /><br />
        Update Data<br />
        Dari<input type="text" name="from" /><br />
        Ke<input type="text" name="to" /><br />
        Type<select name="kolom">
            <option value="1">Name</option>
            <option value="2">Nick</option>
            <option value="3">Phone</option>
        </select><br />
        <input type="submit" value="Update" name="update" />
        <br /><br />
        Delete<br />
        No<input type="text" name="del" /><br />
        <input type="submit" value="Delete" name="delb" /><br />
        <br />
        <input type="submit" value="Quit" name="end" /><br />
    </form>

    <?php
    if(isset($_POST["add"])) {
        $name=$_POST['name'];
        $nick=$_POST['nick'];
        $phone=$_POST['phone'];
        if($con->query("INSERT INTO address_book (Name,Nick,Phone)
                        VALUES ('".$name."','".$nick."','".$phone."')")==true) {
            echo "Data Berhasil Ditambahkan<br>";
        }
        else echo "Gagal";
    }

    if(isset($_POST["show"])) {
        $sql="SELECT No, Name, Nick, Phone FROM address_book";
        $table=mysqli_query($con,$sql);

        if(mysqli_num_rows($table)>0) {
            echo "<table border='1'>
                      <tr><th>No</th><th>Name</th><th>Nick</th><th>Phone</th></tr>";
            while($row=mysqli_fetch_assoc($table)) {
                echo "<tr>";
                echo "<td>".$row["No"]."</td>";
                echo "<td>".$row["Name"]."</td>";
                echo "<td>".$row["Nick"]."</td>";
                echo "<td>".$row["Phone"]."</td>";
            }
        }
        else {
            echo "Tabel Kosong";
        }
    }

    if(isset($_POST["delb"])) {
 //       $todel=$_POST('del');
        if($con->query("DELETE FROM address_book WHERE No=".$_POST["del"]."")==true) {
            echo "Data No ".$_POST["del"]." Berhasil Di Hapus";
        }
    }

    if(isset($_POST["update"])) {
        $from=$_POST["from"];
        $to=$_POST["to"];
        if($_POST["kolom"]) {
            $val=$_POST["kolom"];
            if($val==1) {
                $kolom="Name";
            }
            else if($val==2) {
                $kolom="Nick";
            }
            else if($val==3) {
                $kolom="Phone";
            }

            if($con->query("UPDATE address_book
                            SET ".$kolom." = '".$to."'
                            WHERE ".$kolom." = '".$from."'")==true) {
                echo "Update Data $from->$to Berhasil<br>";
            }
            else {
                echo "Update Gagal atau Data Sudah di Update<br>";
            }
        }
    }

        if(isset($_POST["end"])) {
            $con->close();
            echo "Koneksi Ke Database Telah Ditutup";
        }

    ?>

</body>
</html>
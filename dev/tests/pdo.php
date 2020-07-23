<?php
$server = "localhost";
$user = "test";
$pass = "test";
$db = "mysqlrealdb";

function executequery($sqlarray, $server, $user, $pass, $db){
  $con = mysqli_init();
  //$mysqli = mysqli_init();
  mysqli_options($con, MYSQLI_OPT_CONNECT_TIMEOUT, 10);

  //$conn = mysqli_real_connect($con, $server,$user,$pass, $db);
  $conn = $con->real_connect($server,$user,$pass, $db);
  if(!$conn){
        die("connection failed: ". mysqli_connect_error());
  }
  echo "connected successfully..<br>";

  foreach ($sqlarray as $sql){

          usleep(500000);
          echo "<br>";
          if(mysqli_real_query($con,$sql) === TRUE){
                echo "Query executed successfully : ". $sql;
          } else {
                echo "Error executing query: ".$conn->error;
          }

  }
  mysqli_close($con);
}


function executereadquery($sqlarray, $sel, $server, $user, $pass, $db){
        try{
      $con = mysqli_init();
      mysqli_options($con, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
          //$conn = mysqli_real_connect($con, $server,$user,$pass,$db);
          $conn = new PDO("mysql:host={$server};dbname={$db}",$user,$pass);
          if(!$conn){
                die("connection failed: ". $conn->connect_error);
          }
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "connected successfully<br>";

          foreach ($sqlarray as $sql){

          usleep(25000);
          echo "<br>";
          if($sel ===TRUE){
                //$query = $conn->prepare($sql);
                $result = $conn->query($sql);
                //$result = mysqli_
                echo "Select query ".$sql." results<br>";
                //if(mysqli_num_rows($result) > 0){
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                         echo "id: ". $row["id"]. " - Name: ". $row["firstname"]. " " . $row["lastname"]. "<br>";
                        }
                //}
                  }
                  else {
                        $query = $conn->prepare($sql);
                        $query->execute();
                        echo "Query executed successfully : ". $sql;
                  } //else {
                        //echo "Error executing query: ".$conn->error;
                  //}
          }
          //$conn->close();
          $conn = null;
        }
        catch (PDOException $e)
        {
                echo "PDO Error <br>".$e->getMessage() ."<br>";
                die();
        }
}

$sqlcudarray = array(
"CREATE TABLE MyGuests (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, firstname VARCHAR(30) NOT NULL, lastname VARCHAR(30) NOT NULL, reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)",
"INSERT INTO MyGuests (firstname, lastname) VALUES ('John', 'Doe')",
"INSERT INTO MyGuests (firstname, lastname) VALUES ('Jane', 'Doe')",
"INSERT INTO MyGuests (firstname, lastname) VALUES ('Steve', 'Jobs')",
"INSERT INTO MyGuests (firstname, lastname) VALUES ('Steve', 'Wozniak')",
"INSERT INTO MyGuests (firstname, lastname) VALUES ('Steve', 'Muller')",
"INSERT INTO MyGuests (firstname, lastname) VALUES ('Abdul', 'Kalam')",
"INSERT INTO MyGuests (firstname, lastname) VALUES ('Nirav', 'Modi')",
"INSERT INTO MyGuests (firstname, lastname) VALUES ('Narendar', 'Modi')",
"INSERT INTO MyGuests (firstname, lastname) VALUES ('Amit', 'Sha')",
"DELETE FROM MyGuests where id=2",
"UPDATE MyGuests SET lastname='Dowe' where id=1",
);

echo "<hr> select query<br>";
$selarray = array(
"SELECT id, firstname, lastname FROM MyGuests",
"SELECT id, firstname, lastname FROM MyGuests where id=1",
"SELECT id, firstname, lastname FROM MyGuests where firstname='Steve'",
"SELECT id, firstname, lastname FROM MyGuests ORDER BY lastname",
"SELECT id, firstname, lastname FROM MyGuests LIMIT 2, 1",
);
// Create database, update and delete.

$sqlcr = array("CREATE DATABASE ".$db);
executequery($sqlcr, $server, $user, $pass, "");
echo "<hr> other queries<br>";

executereadquery($sqlcudarray, FALSE, $server, $user, $pass, $db);
executereadquery($selarray, TRUE, $server, $user, $pass, $db);

echo "<hr> drop query<br>";
$sqldel = array("DROP DATABASE ".$db);
executequery($sqldel, $server, $user, $pass, $db);
?>
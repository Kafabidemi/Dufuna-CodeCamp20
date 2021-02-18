<?php
require_once('connection.php');

echo "<h2> List of Customers at Taries Empire </h2>";

class Customer extends Connection {
    public function test()  {
        try{
            /* ACCESSING E-COMMERCE DATABASE AND QUERYING THE DATABASE*/
            
            // $use_db = "USE taries_empire";
            $sql = "SELECT * FROM customers";

        //    $this->connect()->exec($use_db);
            $stmt = $this->connect()->query($sql);
            $result = $stmt->fetchAll();
            
            /* GENERATING COOKIES
            1. result is initalized to get all records from database
            2. This result is serialize to change the array/object to simple string/text file which is required to create cookies.
            */
           
            setcookie("customer", serialize($result), time() + (86400 * 30), "/", "", false); //60sec *60mins *24hours/day => 86400 = 1 day
            return $result;
        } catch (PDOException $err) {
            die('ERROR: Could not execute' .$sql . $err->getMessage());
                                    }
    }
}

$try = new Customer();
$result = isset($_COOKIE['customer']) ? unserialize($_COOKIE['customer']) : $try->test();


    // To display results on the browser as a table, we convert the result to array/object.
    //$output = unserialize($_COOKIE["customer"]);
    
    if(count($result) > 0){
        echo"<table>";
            echo"<tr>";
                echo"<th> S/N </th>";
                echo"<th> Full Name </th>";
                echo"<th> Email Address </th>";
                echo"<th> Created At </th>";
                echo"<th> Actions </th>";
            echo"</tr>";
        // Loop through to access records (Objects in an array i.e datatype <=> JSON formatt)
        foreach($result as $row){
            echo"<tr>";
                echo "<td>" . $row['customer_id'] ."</td>";
                echo "<td>" . $row['first_name'] .$row['last_name'] ."</td>";
                echo "<td>" . $row['email'] ."</td>";
                echo "<td>" . $row['created_at'] ."</td>";
                echo "<td>" . '<button> View </button>' . "</td>";
            echo"</tr>";
        }
        echo"<table>";

        // Close/Free result set
        unset($result);
    }else{
        echo 'No records matching your query were found.';
    }
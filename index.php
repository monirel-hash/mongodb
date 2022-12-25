<?php

    require_once  './vendor/autoload.php';
    $con = new MongoDB\Client("mongodb://localhost:27017");


    function checkdb(MongoDB\Client $con, String $dbname ): bool
    {
        $dbs = $con->listDatabases();

        // Search for the database in the list of databases
        $dbExists = false;
        foreach ($dbs as $db) {
            if ($db->getName() == $dbname) {
                $dbExists = true;
                break;
            }
        }
        return $dbExists;
    }


    function getdbs(MongoDB\Client $con): Array
    {
        $dbs = $con->listDatabases();

        // Search for the database in the list of databases
        $databases = [];
        foreach ($dbs as $db)
            array_push($databases, $db->getName());

        return $databases;
    }

?>

<html>
   <body>
      <form method="post">
         Database name: 
         <select name="dbname" id="dbname">
            <?php
                $dbs = getdbs($con);
                foreach($dbs as $db)
                    echo "<option value='$db'>$db</option>";
            ?>  
         </select></br>
         Collection name: <input type="text" name="colname"><br>
         <input type="submit" value="Create">
      </form>

      <?php
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Include the MongoDB PHP driver
            
            //require_once '/path/to/mongodb-php-driver/vendor/autoload.php';

            // Connect to MongoDB
            

            // Get the database and collection names from the form
            $dbname = $_POST["dbname"];
            $colname = $_POST["colname"];

            // Create a new collection in the selected database
            $db = $con->{$dbname};
            $collection = $db->createCollection($colname);

            if ($collection)echo 'sucsseeed';
         }
      ?>
   </body>
</html>










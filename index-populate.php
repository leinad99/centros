<?php
$statusMessage = "";
  
  // Since this request will alter the DB, we use POST instead of GET
if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
    if(isset($_COOKIE['user'])) {

        $email = $_COOKIE['user'];

        // Start the DB operations
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "centros";
                    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_errno) {
            console.log("Could not connect to database");
        }
        else {
            // Get the information for the relevant accounts
            $stmt = $conn->prepare("SELECT * FROM favorites WHERE user=?");
            
            $stmt->bind_param("s", $email);
            $stmt->execute();
            
            $res = $stmt->get_result();

            // var to hold return html
            $favs = "";
            while($row = $res->fetch_assoc()){
                $favs .=
                "<div class='item'>" .
                    "<a class='item-link' target='_blank' href=" . $row["itemLink"] . ">" .
                        "<div class='row'>" . 
                            "<div class='col-xs-3'>" .
                            "</div>" .
                            "<div class='col-xs-9'>" .
                            "<div class='item-title'>" .
                                $row["title"] .
                            "</div>" .
                            "<div class='price'>" .
                                $row["price"] . 
                            "</div>" .
                        "</div>" . 
                    "</div>" . 
                "</a>" .
            "</div>";            

            }
            $statusMessage = $favs;
            
            
            $stmt->close();
        }
        
        $conn->close();
          
    }
    else{
        $statusMessage = "";
    }
}
else{
    $statusMessage = "";
}

// Echo the result        
echo($statusMessage);

?>

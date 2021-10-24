<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sender</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    
    <?php
        
        require_once('EmailHandler.php');
        require_once('Database.php');

        $emailHandler = new EmailHandler;
        $lists = $emailHandler->getList();
        $data = $lists["data"];
        
        $listIds = array();
        $listIdss = array();
        $eventIds = array();
        
        for ($i=0; $i < count($data); $i++) { 
            array_push($listIds,$data[$i]["name"]);
            array_push($listIdss,$data[$i]["id"]);
        }

        $db = new Database;

        $conn = $db->connection();
        $emails = array();
        
        
        echo '<div class="container">';
        
        echo '<h3>Email Sender </h3>';
        echo '<div><input id="pass" placeholder="password" type="password" onchange="check(\'halo123\')"></input></div>';
        // echo '<input id="pass" placeholder="password" type="password" onchange="check(\'halo\')"></input>';
        

        $queryEvents = "SELECT * FROM jos_event";
        
        
        $events = $conn->query($queryEvents);
        
        echo '<form method="POST" action="">';
        echo '<div id="container"><label class="content" for="event">pilih event :</label>';
        echo '<select class="content" id="event" name="event" onchange="this.form.submit()">';
        
        // echo '<script>';
        if ($events->num_rows > 0) {
            echo '<option value="" disabled selected>--select--</option>';
            while($row = $events->fetch_assoc()) {
                // echo 'console.log('+$row+')';
                echo '<option value="';
                
                if (in_array($row["id"], $listIds) == false) {
                    $emailHandler->createList($row["id"]);
                }
                echo $row["id"];
                echo '">';
                echo $row["title"];
                echo '</option>';
            }
        }
        
        
        echo "</select></form>";
        echo '<label class="content" for="template">pilih template :</label>';
        echo '<select class="content" id="template" name="template" >';
        echo '<option value="" disabled selected>--select--</option>';
        echo "</select>";
        echo "</div>";
        
        echo '<div class="scrollable">';
        if(isset($_POST["event"]))
        {
            $result = $emailHandler->getSubscribers($_POST["event"]);
            $data = $result["data"];
            $emails = array();

            
            $queryUsers = 'SELECT * FROM jos_event_booking where event_id='.$_POST["event"];
            $users = $conn->query($queryUsers);
            if ($users->num_rows > 0) {
                for ($i=0; $i < count($data); $i++) { 
                    array_push($emails,$data[$i]["email"]);
                    
                }
                while($row = $users->fetch_assoc()) {
                    
                    // echo in_array($row["user_email"],$emails);
                    if (in_array($row["user_email"],$emails) == false) {
                        $emailHandler->addSubscriber(
                            $listIdss[array_search($_POST["event"],$listIds)], 
                            $row["user_name"],
                            $row["user_email"],
                            $row["user_phone"]
                        );
                    }

                    echo $row["user_email"];
                    echo '<br/>';
                    
        
                    
                }
            }
        }

        
        
        
        echo '</div>';
        echo '<button class="btn" id="btnKirim" disabled="true" >Kirim email ke semua peserta</button>';
        echo '</div>';
        // $conn->close();

        // $conn = $db->connection();
        
        $conn->close();

        
        
        
    ?>
        
        
        
    <script>
        function check(pass) {
            
            if (document.getElementById("pass").value == pass) {
                document.getElementById("btnKirim").disabled = false;
            }else{
                document.getElementById("btnKirim").disabled = true;
            }
        }

        
        
    </script>
</body>
</html>
<?php
include 'database.php';


function handleAction($con, $arc_id, $action) {
 
    $arc_id = mysqli_real_escape_string($con, $arc_id);

    if ($action === 'restore') {
   
        $restore_query = "
            INSERT INTO officials (Position_ID, Firstname, Middlename, Lastname, Suffix, Gender, Birthdate, Contact_Number, Email, Date_Created, Fullname)
            SELECT Position_ID, Firstname, Middlename, Lastname, Suffix, Gender, Birthdate, Contact_Number, Email, Date_Created, Fullname
            FROM officials_archive
            WHERE Archive_ID = $arc_id;
            DELETE FROM officials_archive 
            WHERE Archive_ID = $arc_id;
        ";


        if (mysqli_multi_query($con, $restore_query)) {
            do {
             
                if ($result = mysqli_store_result($con)) {
                    mysqli_free_result($result);
                }
                
                if (mysqli_more_results($con)) {
                 
                }
            } while (mysqli_next_result($con));
            
            echo "Official restored successfully!";
        } else {
            echo "Error restoring official: " . mysqli_error($con);
        }
    } elseif ($action === 'delete') {
   
        $delete_query = "DELETE FROM officials_archive WHERE Archive_ID = $arc_id";

       
        if (mysqli_query($con, $delete_query)) {
            echo "Official deleted successfully!";
        } else {
            echo "Error deleting official: " . mysqli_error($con);
        }
    } else {
        echo "Invalid action!";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['arc_id']) && isset($_POST['action'])) {
        handleAction($con, $_POST['arc_id'], $_POST['action']);
    }
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Barangay Officials</title>
        <link rel="stylesheet" href="http://localhost/BrgyMalinao/Backend/CSS/archiveModal.css">
    </head>
    <body>

       
        <div id="archiveSettingsModal" class="modal10">
            <div class="modal-content10">
                <div class="col10">
                    <div class="bg10">
                        <span class="txt10">Archive <br> Officials</span>
                    </div>
                </div>
                <div class="col10">
                    <span class="close-btn10" onclick="closeModal('archiveSettingsModal')">&times;</span>
                    <div class="div10"></div>
                    <div class="Scrollable-table10">
                    <table>
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Full Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="officialsArchive">
                        <?php
                     
                        $archived_officials = [];
                        $result = mysqli_query($con, "SELECT o.*, p.Position, CONCAT_WS(' ', o.Firstname, COALESCE(o.Middlename, ''), o.Lastname, COALESCE(o.Suffix, '')) AS Fullname FROM officials_archive o JOIN position p ON o.Position_ID = p.Position_ID");
                        while ($row = mysqli_fetch_assoc($result)) {
                            $archived_officials[] = $row;
                        }

                       
                        if (count($archived_officials) > 0) {
                            
                            foreach ($archived_officials as $official) {
                               
                                echo "<tr>";
                                echo "<td>" . $official['Position'] . "</td>";
                                echo "<td>" . $official['Fullname'] . "</td>";
                                echo "<td>";
                                
                                echo "<button class=\"button-blue\" onclick=\"performAction(" . $official['Archive_ID'] . ", 'restore')\">Restore</button>";
                                echo "<button class=\"button-red\" onclick=\"performAction(" . $official['Archive_ID'] . ", 'delete')\">Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                         
                            echo "<tr><td colspan=\"3\">No archived officials found</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
         
            function performAction(arc_id, action) {
                
                if (confirm("Are you sure you want to " + action + " this official?")) {
                    
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            
                            alert('Official restored successfully.');
                           
                            location.reload();
                        }
                    };
                    
                    xhttp.open("POST", 'archiveSettingsModal.php', true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("arc_id=" + arc_id + "&action=" + action);
                }
            }

            
            function closeModal(archiveSettingsModal) {
                document.getElementById(archiveSettingsModal).style.display = 'none';
            }
        </script>
    </body>
    </html>

<!doctype html>
<html lang="en">
<head>
    <title>Blotter Add</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/BlotterAddM.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/SideBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div id="BlotterAddModal" class="modal10">
        <div class="modal-content10">
            <div class="col7">
                <h3 class="AddTitle">Manage Blotter</h3>
                    <span class="close-btn10" onclick="closeModal('BlotterAddModal')">&times;</span>
                        <form id="BlotterAddForm" action="insert_blotter.php" method="POST">
                            <div class="align10">
                                <div class="row10">
                                    <div class="form-group">
                                        <label for="complainant">Complainant:</label> <br>
                                        <input type="text" id="addname" name="complainant" placeholder="Enter complainant" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="respondent">Respondent:</label> <br>
                                        <input type="text" id="addnesp" name="respondent" placeholder="Enter respondent" required>
                                    </div>
                                </div><br>
                                <div class="row10">
                                    <div class="form-group">
                                        <label for="victim">Victim:</label> <br>
                                        <input type="text" id="addvic" name="victims" placeholder="Enter victim" >
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Type:</label> <br>
                                        <select id="addtype" name="type" required>
                                            <option value="">Select Type</option>
                                            <option value="Incident">Incident</option>
                                            <option value="Accident">Accident</option>
                                            <option value="Complaint">Complaint</option>
                                            <option value="Report">Report</option>
                                        </select>
                                    </div>
                                </div><br>
                                <div class="row10">
                                    <div class="form-group">
                                        <label for="location">Location:</label> <br>
                                        <input type="text" id="addloc" name="location" placeholder="Enter location" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Date:</label> <br>
                                        <input type="date" id="adddate" name="date" required>
                                    </div>
                                </div><br>
                                <div class="row10">
                                    <div class="form-group">
                                        <label for="time">Time:</label> <br>
                                        <input type="time" id="addtime" name="time" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status:</label> <br>
                                        <select id="addStat" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="Schedule">Schedule</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Resolved">Resolved</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                    </div>
                                </div><br>

                                <div class="row11">
                                    <label for="details">Detail:</label> <br>
                                    <div class="textarea-container">
                                        <textarea id="resizable-textarea" placeholder="Type here..." name="blotter_details"></textarea>
                                    </div>
                                </div>
                                
                                <div class="action-buttons">
                                    <button type="submit" id="add-button10" class="button10">Add</button>
                                    <button type="button" id="cancel-button10" class="button10" onclick="closeModal('BlotterAddModal')">Cancel</button>
                                </div>
                            </div>
                        </form>
            </div>
        </div>
    </div>

    <script>
        function closeModal(BlotterAddModal) {
            document.getElementById(BlotterAddModal).style.display = 'none';
        }
    </script>
</body>
</html>

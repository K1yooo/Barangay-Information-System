<!doctype html>
<html lang="en">
<head>
    <title>Blotter Update</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/blotterUpdate.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/SideBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div id="BlotterUpModal" class="modal12">
    <div class="modal-content12">
        <div class="col12">
            <h3 class="AddTitle12">Viewing Report</h3>
            <span class="close-btn12" onclick="closeModal('BlotterUpModal')">&times;</span>
            <form id="BlotterAddForm" action="update_blotter.php" method="POST">
                <input type="hidden" id="upblotter_id" name="blotter_id">

                <div class="align12">
                    <div class="row12">
                        <div class="form-group">
                            <label for="complainant">Complainant:</label> <br>
                            <input type="text" id="upname" name="complainant" required>
                        </div>
                        <div class="form-group">
                            <label for="respondent">Respondent:</label> <br>
                            <input type="text" id="upnesp" name="respondent" required>
                        </div>
                    </div><br>
                    <div class="row12">
                        <div class="form-group">
                            <label for="victim">Victim:</label> <br>
                            <input type="text" id="upvic" name="victims">
                        </div>
                        <div class="form-group">
                            <label for="type">Type:</label> <br>
                            <select id="uptype" name="type" required>
                                <option value="">Select Type</option>
                                <option value="Incident">Incident</option>
                                <option value="Accident">Accident</option>
                                <option value="Complaint">Complaint</option>
                                <option value="Report">Report</option>
                            </select>
                        </div>
                    </div><br>
                    <div class="row12">
                        <div class="form-group">
                            <label for="location">Location:</label> <br>
                            <input type="text" id="uploc" name="location" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date:</label> <br>
                            <input type="date" id="update" name="date" required>
                        </div>
                    </div><br>
                    <div class="row12">
                        <div class="form-group">
                            <label for="time">Time:</label> <br>
                            <input type="time" id="uptime" name="time" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label> <br>
                            <select id="upStat" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Schedule">Schedule</option>
                                <option value="Pending">Pending</option>
                                <option value="Resolved">Resolved</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                    </div><br>
                    <div class="row13">
                        <label for="details">Detail:</label> <br>
                        <div class="textarea-container">
                            <textarea id="upresizable-textarea" placeholder="Type here..." name="blotter_details"></textarea>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" id="update-button12" class="button10">Update</button>
                        <button type="button" id="cancel-button12" class="button10" onclick="closeModal('BlotterUpModal')">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function closeModal(BlotterUpModal) {
        document.getElementById(BlotterUpModal).style.display = 'none';
    }

    function viewReport(reportId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_report.php?id=' + reportId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);

                document.getElementById('upblotter_id').value = data.blotter_id;
                document.getElementById('upname').value = data.complainant;
                document.getElementById('upnesp').value = data.respondent;
                document.getElementById('upvic').value = data.victims;
                document.getElementById('uptype').value = data.type;
                document.getElementById('uploc').value = data.location;
                document.getElementById('update').value = data.date;
                document.getElementById('uptime').value = data.time;
                document.getElementById('upStat').value = data.status;
                document.getElementById('upresizable-textarea').value = data.blotter_details;

                document.getElementById('BlotterUpModal').style.display = 'block';
            }
        };
        xhr.send();
    }
</script>

</body>
</html>

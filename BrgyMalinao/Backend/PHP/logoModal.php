<?php
include 'database.php';

    $querylogo = "SELECT Logo FROM logo WHERE logo_id = 1";
    $resultlogo = mysqli_query($con, $querylogo);

    if ($resultlogo) {
        $row = mysqli_fetch_assoc($resultlogo);
        $logo = base64_encode($row['Logo']);
    } else {
        echo "Error: " . mysqli_error($con);
    }
?>

<!doctype html>
<html lang="en">
<head>
    <title>Logo Settings</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="/BrgyMalinao/Backend/CSS/SideBar.css">
    <link rel="stylesheet" type="text/css" href="/BrgyMalinao/Backend/CSS/logoModal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div id="logoSettingsModal" class="modal6" style="display: none;">
        <div class="modal-content6">
            <div class="col6">
                <div class="bg6">
                    <span class="txt6">LOGO <br> Settings</span>
                </div>
            </div>
            <span class="close-btn6" onclick="closeModal('logoSettingsModal')">&times;</span>
            <div class="align6">
                <form id="logoSettingsForm" enctype="multipart/form-data">
                    <div class="form-group">
                       <div class="box6">
                       <img src="data:image/png;base64,<?php echo $logo; ?>" class="imgLogo" alt="Logo of Malinao">
                       </div>
                    </div>
                  <br><br>
                    <div class="form-group">
                        <label for="barangay-logo">Upload Barangay Logo:</label><br>
                        <input type="file" id="barangay-logo6" name="barangay_logo" accept="image/*" onchange="handleFileUpload(this)" required>
                    </div>
                    <div class="action-buttons6">
                        <button type="button" class="cancel-button6" onclick="closeModal('logoSettingsModal')">Cancel</button>
                        <button type="button" class="save-button6" onclick="handleLogoSettings()">Save</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <script>
    function handleFileUpload(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.box6 img').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function handleLogoSettings() {
        var form = document.getElementById('logoSettingsForm');
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_logo.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert(xhr.responseText);
                closeModal('logoSettingsModal');
            } else {
                alert('Error: ' + xhr.statusText);
            }
        };
        xhr.send(formData);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }
    </script>
</body>
</html>
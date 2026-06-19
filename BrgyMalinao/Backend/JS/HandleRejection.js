function rejectApplication(button) {
    var confirmation = confirm("Are you sure you want to reject this applicant?");
    if (confirmation) {
        var row = button.closest('tr');
        var id = row.cells[0].innerText; // Assuming ID is in the first column
        // AJAX call to PHP script to reject the applicant
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText.trim() === "success") {
                    row.remove(); // Remove the row from the table on successful rejection
                } else {
                    alert("Error rejecting applicant: " + this.responseText);
                }
            }
        };
        xhttp.open("GET", "reject.php?ID=" + id, true);
        xhttp.send();
    }
}
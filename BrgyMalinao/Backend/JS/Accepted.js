function acceptApplication(id) {
    if (confirm("Are you sure you want to accept this applicant?")) {
        // Create an AJAX request to handle the accept action
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "accept.php?ID=" + id, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response from the server
                alert(xhr.responseText);
                // Optionally, refresh the page or update the table to reflect the changes
                location.reload();
            }
        };
        xhr.send();
    }
}
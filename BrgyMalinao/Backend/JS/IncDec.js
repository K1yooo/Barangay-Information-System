function toggleTableRows() {
    var rows = Array.from(document.querySelectorAll('tbody tr')); // Select all table rows and convert NodeList to Array
    var currentOrder = document.getElementById('IncDec').value;

    if (currentOrder === '▲') {
        rows.sort(function(a, b) {
            return b.cells[0].textContent - a.cells[0].textContent; // Sort based on Resident ID in descending order
        });
        rows.forEach(function(row) {
            row.parentElement.appendChild(row); // Reorder rows in the table
        });
        document.getElementById('IncDec').value = '▼';
    } else {
        rows.sort(function(a, b) {
            return a.cells[0].textContent - b.cells[0].textContent; // Sort based on Resident ID in ascending order
        });
        rows.forEach(function(row) {
            row.parentElement.appendChild(row); // Reorder rows in the table
        });
        document.getElementById('IncDec').value = '▲';
    }
}

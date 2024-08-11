$(document).ready(function() {
    // Function to retrieve and display records
    function showRecords() {
        $.post('submit1.php', { action: 'retrieve' }, function(data) {
            $('#records').empty();
            if (data.length === 0) {
                $('#records').append('<div>No records found.</div>');
            } else {
                $.each(data, function(index, record) {
                    $('#records').append('<div>' + 
                        'ID: ' + record.id + 
                        ' - Faculty: ' + record.faculty + 
                        ' - Branch: ' + record.branch + 
                        ' - File: <a href="' + record.file_path + '" target="_blank">' + record.file_path + '</a>' + 
                        ' <button onclick="updateRecord(' + record.id + ')">Update</button>' + 
                        ' <button onclick="deleteRecord(' + record.id + ')">Delete</button>' + 
                        '</div>');
                });
            }
        }, 'json').fail(function() {
            $('#records').append('<div>Failed to load records.</div>');
        });
    }

    // Function to update a record
    function updateRecord(id) {
        var new_faculty = prompt("Enter new faculty:");
        var new_branch = prompt("Enter new branch:");
        if (new_faculty && new_branch) {
            $.post('submit1.php', { action: 'update', id: id, new_faculty: new_faculty, new_branch: new_branch }, function(response) {
                alert(response);
                showRecords();
            }).fail(function() {
                alert("Failed to update record.");
            });
        }
    }

    // Function to delete a record
    function deleteRecord(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            $.post('submit1.php', { action: 'delete', id: id }, function(response) {
                alert(response);
                showRecords();
            }).fail(function() {
                alert("Failed to delete record.");
            });
        }
    }

    // Form validation
    function validateForm() {
        const faculty = document.getElementById('faculty').value;
        const branch = document.getElementById('branch').value;
        const file = document.getElementById('file').value;

        if (!faculty || faculty.trim() === "") {
            alert("Faculty cannot be empty.");
            return false;
        }
        if (!branch || branch.trim() === "") {
            alert("Branch cannot be empty.");
            return false;
        }
        if (!file) {
            alert("Please select a file to upload.");
            return false;
        }

        return true;
    }

    // Expose functions to global scope
    window.updateRecord = updateRecord;
    window.deleteRecord = deleteRecord;
    window.validateForm = validateForm;

    // Show records on page load
    showRecords();
});

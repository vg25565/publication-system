// Form validation
function validateForm() {
    const faculty = document.getElementById('faculty').value;
    const branch = document.getElementById('branch').value;
    const grievance = document.getElementById('grievance').value;

    if (!faculty || faculty.trim() === "") {
        alert("Faculty name cannot be empty.");
        return false;
    }
    if (!branch || branch.trim() === "") {
        alert("Branch cannot be empty.");
        return false;
    }
    if (!grievance || grievance.trim() === "") {
        alert("Grievance cannot be empty.");
        return false;
    }

    return true;
}
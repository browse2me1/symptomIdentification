
function toggleSymptomList() {
    const list = document.getElementById("symptom-list");
    const btn = document.getElementById("toggleBtn");

    if (list.style.display === "none" || list.style.display === "") {
        list.style.display = "block";
        btn.textContent = "Hide Symptom List";
    } else {
        list.style.display = "none";
        btn.textContent = "Show Symptom List";
    }
}

function confirmDelete(id) {
    document.getElementById('deleteId').value = id;
    document.getElementById('confirmModal').style.display = 'block';
}

function hideModal() {
    document.getElementById('confirmModal').style.display = 'none';
}

// ✅ JS Validation
function validateSymptomForm() {
    const input = document.getElementById("sym_name");
    const error = document.getElementById("error-msg");
    const value = input.value.trim();

    const pattern = /^[A-Za-z\s]{3,}$/;

    if (!pattern.test(value)) {
        error.textContent = "Symptom name must contain only letters and spaces (min 3 characters).";
        error.style.display = "block";
        return false;
    }

    error.style.display = "none";
    return true;
}


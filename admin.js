function toggleDiseaseList() {
    const list = document.getElementById("disease-list");
    const btn = document.getElementById("toggleBtn");

    if (list.style.display === "none" || list.style.display === "") {
        list.style.display = "block";
        btn.textContent = "Hide Disease List";
    } else {
        list.style.display = "none";
        btn.textContent = "Show Disease List";
    }
}


function validateDiseaseForm() {
    const name = document.getElementById("disease_name").value.trim();
    const desc = document.getElementById("description").value.trim();
    const prev = document.getElementById("prevention").value.trim();
    const errorDiv = document.getElementById("error-msg");
    

    // Reset error
    errorDiv.style.display = "none";
    errorDiv.innerHTML = "";

    const nameRegex = /^[A-Za-z\s]{3,}$/;
    const symnameRegex = /^[A-Za-z\s]{3,}$/;
    if (!nameRegex.test(name)) {
        errorDiv.innerHTML = "❗ Disease name must contain only letters and spaces.input known disease name (min 3 characters).";
        errorDiv.style.display = "block";
        return false;
    }

    if (desc.length < 100) {
        errorDiv.innerHTML = "❗ Description must be at least 10 characters.";
        errorDiv.style.display = "block";
        return false;
    }

    if (prev.length < 10) {
        errorDiv.innerHTML = "❗ Prevention must be at least 100 characters.";
        errorDiv.style.display = "block";
        return false;
    }
   

    return true;
}

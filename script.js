const symptomInput = document.getElementById("symptomInput");
const symptomList = document.getElementById("symptomsList");

// Show the symptom list when clicking the input
symptomInput.addEventListener("click", () => {
    symptomList.classList.toggle("hidden");
});

// Hide the list when clicking outside
   document.addEventListener("click", (e) => {
    if (!symptomInput.contains(e.target) && !symptomList.contains(e.target)) {
        symptomList.classList.add("hidden");
    }
})
;

// Update input with selected symptoms

function updateSymptomInput() {
    const checkboxes = document.querySelectorAll('#symptomsList input[type="checkbox"]');
    const selectedSymptoms = [];

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedSymptoms.push(checkbox.dataset.name); // Get symptom name
        }
    });

    // Display the selected symptoms in the input
    document.getElementById('symptomInput').value = selectedSymptoms.join(', ');
}
//prompt the user to select symptoms
document.getElementById('symptomForm').addEventListener('submit', function(e) {
    const checked = document.querySelectorAll('input[name="symptoms[]"]:checked');
    const errorMsg = document.getElementById('errorMsg');

    if (checked.length === 0) {
        e.preventDefault(); // Stop form submission
        errorMsg.textContent = "Please select at least one symptom before checking for disease.";
        errorMsg.style.display = "block";
    } else {
        errorMsg.style.display = "none"; // Clear message if previously shown
    }
});


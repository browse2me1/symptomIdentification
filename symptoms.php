<?php
if (!isset($_SESSION['disclaimer_accepted'])) {
    header("Location: disclaimer.php");
    exit();
}
?>

<?php
include 'dbcon.php'; // make sure this connects properly
$symptoms = $conn->query("SELECT * FROM symptoms ORDER BY symptom_name ASC");
?>

<div id="symptomsList" class="hidden">
    <h4>Select your symptoms:</h4>
      <div class="scrollable">
                <div class="symptom-list" id="symptomList">
    <?php while ($row = $symptoms->fetch_assoc()): ?>
        <label>
            <input type="checkbox" name="symptoms[]" value="<?php echo $row['symptom_id']; ?>" data-name="<?php echo ($row['symptom_name']); ?>" onclick="updateSymptomInput()">
            <?php echo htmlspecialchars($row['symptom_name']); ?>
        </label>
    <?php endwhile; ?>
</div>

         </div>
</div>
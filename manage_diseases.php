<?php
include 'dbcon.php';
include 'admin_navbar.php'; 

// Ensure only admins can access
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submission for adding/updating
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $prevention = $_POST['prevention'];

   
    // Check if editing
    if (!empty($_POST['disease_id'])) {
        $id = intval($_POST['disease_id']);
        $stmt = $conn->prepare("UPDATE diseases SET disease_name=?, description=?, prevention=? WHERE disease_id=?");
        $stmt->bind_param("sssi", $name, $description, $prevention, $id);
        $_SESSION['message'] = "<div class='alert alert-success'>Updated successfully.</div>";
    } else {
        // New insert
        $stmt = $conn->prepare("INSERT INTO diseases (disease_name, description, prevention) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $prevention);
        $_SESSION['message'] = "<div class='alert alert-success'>Disease Added successfully.</div>";
        header("Location: manage_diseases.php");
    }

    $stmt->execute();
    $stmt->close();
    header("Location: manage_diseases.php"); // Avoid form resubmission
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM diseases WHERE disease_id = $id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] =  "<div class='alert alert-success'>✅ Disease deleted successfully.</div>";
    } else {
        // Friendly error message if deletion fails due to foreign key
        $_SESSION['message'] = "<div class='alert alert-danger'>❗ Unable to delete. This disease is still mapped to symptoms. Please remove related mappings first.</div>";
    }

    header("Location: manage_diseases.php");
    exit();
}

// Fetch diseases
$diseases = $conn->query("SELECT * FROM diseases ORDER BY disease_id ASC");
// Fetch disease for editing
$editDisease = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM diseases WHERE disease_id = $id");
    $editDisease = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="admin.css">
  <?php
     include'admin_header.php';
     ?>

<body>
   
<form class="new-entry" onsubmit="return validateDiseaseForm()" method="post">

    <h2><?php echo $editDisease ? "Edit Disease" : "Add New Disease"; ?></h2>

    <!-- Message from session -->
    <?php if (isset($_SESSION['message'])): ?>
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <?php echo $error; unset($error); ?>
    <?php endif; ?>

    <?php if ($editDisease): ?>
        <input type="hidden" name="disease_id" value="<?php echo $editDisease['disease_id']; ?>">
    <?php endif; ?>

    <b><i>Disease Name:</i></b>
    <input type="text" id="disease_name" onkeypress="return /[a-zA-Z\s]/.test(event.key)" name="name" placeholder="Disease Name"
        value="<?php echo $editDisease['disease_name'] ?? ''; ?>" required>

    <b><i>Description:</i></b>
    <textarea name="description" id="description" onkeypress="return /[a-zA-Z\s]/.test(event.key)" placeholder="Description"
        required><?php echo $editDisease['description'] ?? ''; ?></textarea>

    <b><i>Prevention:</i></b>
    <textarea name="prevention" id="prevention" onkeypress="return /[a-zA-Z\s]/.test(event.key)" placeholder="Prevention"
        required><?php echo $editDisease['prevention'] ?? ''; ?></textarea>

    <!--validation error message -->
    <div id="error-msg" class="alert alert-danger" style="display: none;"></div>

    <button type="submit"><?php echo $editDisease ? "Update" : "Add Disease"; ?></button>

    <?php if ($editDisease): ?>
        <a href="manage_diseases.php"
            style="margin-left: 50px; text-decoration:none; border:1px solid gray; border-radius:3px;background-color:rgb(209, 212, 212);color:black;">
            Cancel Edit
        </a>
    <?php endif; ?>
</form>

</div>
<!-- Toggle Button -->
<?php if (!isset($_GET['edit'])): ?>
    <button onclick="toggleDiseaseList()" id="toggleBtn">Show Disease List</button>
<?php endif; ?>


<!-- Hidden Disease List -->
<div id="disease-list">

<h3>Existing Diseases</h3>
<div class="scrollable" style="overflow-x: auto;">
<table>
        <tr>
            <th>ID</th>
            <th>Disease Name</th>
            <th>Description</th>
            <th>Prevention</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $diseases->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['disease_id']; ?></td>
            <td><?php echo $row['disease_name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['prevention']; ?></td>
            <td class="actions">
                <a  href="?edit=<?php echo $row['disease_id']; ?>" class="edit">Edit</a>
                <a href="#" class="deletee-btn" onclick="confirmDelete(<?php echo $row['disease_id']; ?>)">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>


</div>
<a href="manage.php" style="color:whitblue; display:block; margin-top:20px;">Back to Manage Page</a>
<!-- Delete Confirmation Modal -->
<!-- Confirmation Modal -->
<div id="confirmModal">
    <div class="modal-content">
        <p>Are you sure you want to delete this disease?</p>
        <form method="get" action="">
            <input type="hidden" name="delete" id="deleteId">
            <div class="modal-buttons">
                <button type="submit" style=background-color:red; ;>Yes, Delete</button>
                <button type="button" onclick="hideModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function confirmDelete(id) {
    document.getElementById('deleteId').value = id;
    document.getElementById('confirmModal').style.display = 'block';
}

function hideModal() {
    document.getElementById('confirmModal').style.display = 'none';
}
</script>

<?php
include 'footer.php'
?>
<script src="admin.js"></script>

</body>
</html>

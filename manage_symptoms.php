<?php
include 'admin_navbar.php'; 
include 'dbcon.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location:login.php");
    exit();
}

// Load symptom to edit
$editSymptom = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM symptoms WHERE symptom_id = $id");
    $editSymptom = $res->fetch_assoc();
}

// Handle Add or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['symptom_name']);
    if ($name !== "") {
        if (!empty($_POST['symptom_id'])) {
            // Update
            $id = intval($_POST['symptom_id']);
            $stmt = $conn->prepare("UPDATE symptoms SET symptom_name = ? WHERE symptom_id = ?");
            $stmt->bind_param("si", $name, $id);
            $_SESSION['message'] = "<div class='alert alert-success'Symptom Updated successfully.</div>";
        } else {
            // Insert
            $stmt = $conn->prepare("INSERT INTO symptoms (symptom_name) VALUES (?)");
            $stmt->bind_param("s", $name);
             $_SESSION['message'] = "<div class='alert alert-success'>Symptom added successfully.</div>";
        }
        $stmt->execute();
        $stmt->close();
        header("Location: manage_symptoms.php");
        exit();
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Check if the symptom is used in mapping
    $checkMapping = $conn->query("SELECT * FROM sd_mapping WHERE symptom_id = $id");

    if ($checkMapping && $checkMapping->num_rows > 0) {
        // Symptom is mapped, do not delete
        $_SESSION['message'] = "<div class='alert alert-warning'>
            ⚠️ This symptom is linked to one or more diseases. Please remove the mapping(s) first before deleting.
        </div>";
    } else {
        // Safe to delete
        $delete = $conn->query("DELETE FROM symptoms WHERE symptom_id = $id");

        if ($delete) {
            $_SESSION['message'] = "<div class='alert alert-success'>✅ Symptom deleted successfully.</div>";
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'>❌ Failed to delete symptom. Please try again.</div>";
        }
    }

    // Redirect back to symptom management page
    header("Location: manage_symptoms.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptom Checker|Manage Symptoms</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        body {background-color: #E3F2FD;  }
        input { width: 100%; padding: 10px; margin-top: 10px; }
        button { padding: 10px 15px; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color:white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #f0f0f0; }
        .edit-btn { color: green; text-decoration: none; margin-right: 10px; }
        .delete-btn { color: red; text-decoration: none; }
        #symptom-list { display: none; margin-top:5%; }
        .header { 
            margin-top: -1.5em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            height: 2em;
             }
        .header a { color: white; text-decoration: none; }
        header {
    top: 0px;
    width: 100%;
    text-align: center;
    margin-bottom: 30px;
    background-color: #2c3e50;
    color: white;
    border-top-left-radius: 5px;
   
    
}
#add{
    
    margin-top: 0.5em;
    background-color:#007bff ;
    border:none;
    border-radius:5px;
    width:auto;
    float:left;
}
#add:hover{
    background-color: #E3F2FD;
}
#toggleBtn{
    margin-top:-1em;
    margin-right:20%;
    margin-bottom: 10px;
    background-color:  #758ba3;
    width:auto;
    border:none;
    border-radius:px;
    float:right;
   }
#toggleBtn:hover{
    background-color: #ccc;
   }
.alert-success{
   background-color:rgb(76, 180, 120);
   margin: 2em;
    border-radius: 5px;
}
.alert-danger{
   background-color:rgb(180, 92, 76);
   margin: 2em;
    border-radius: 5px;
}
.alert-warning{
   background-color:rgb(152, 180, 76);
   margin: 2em;
    border-radius: 5px;
}
footer {
    text-align: center;
    margin-top: 40px;
    padding: 20px;
    height: 150px;
   border-radius: 5px;
    background-color: #2c3e50;
    color: #7f8c8d;
}
    </style>
</head>
<?php
     include'admin_header.php';
     ?>
<body>


<h2><?php echo $editSymptom ? "Edit Symptom" : "Add New Symptom"; ?></h2>

<!-- Symptom Form -->
<form class="new-entry" onsubmit="return validateSymptomForm()" method="post">
    <!-- notify -->
    
<?php if (isset($_SESSION['message'])): ?>
    <?php echo $_SESSION['message']; ?>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

    <?php if ($editSymptom): ?>
        <input type="hidden" name="symptom_id" value="<?php echo $editSymptom['symptom_id']; ?>">
    <?php endif; ?>
    <input type="text" name="symptom_name" id= "sym_name" onkeypress="return /[a-zA-Z\s]/.test(event.key)" placeholder="Enter symptom name" value="<?php echo $editSymptom['symptom_name'] ?? ''; ?>" required>
    
    <!--validation error message -->
    <div id="error-msg" class="alert alert-danger" style="display: none;"></div>

    <button type="submit" id="add"><?php echo $editSymptom ? "Update Symptom" : "Add Symptom"; ?></button>
    <?php if ($editSymptom): ?>
        <a href="manage_symptoms.php" style="margin-left: 10px;">Cancel Edit</a>
    <?php endif; ?>
</form>

<!-- Show/Hide Table Toggle -->
<?php if (!isset($_GET['edit'])): ?>
<button onclick="toggleSymptomList()" id="toggleBtn">Show Symptom List</button>
<?php endif; ?>

<!-- Symptom List -->
<?php
$result = $conn->query("SELECT * FROM symptoms ORDER BY symptom_id ASC");
if ($result->num_rows > 0 && !isset($_GET['edit'])):
?>
<div id="symptom-list">
    <h3>Existing Symptoms</h3>
    <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc;">
        <table>
            <tr>
                <th>ID</th>
                <th>Symptom Name</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['symptom_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['symptom_name']); ?></td>
                    <td>
                        <a class="edit-btn" href="?edit=<?php echo $row['symptom_id']; ?>">Edit</a>
                        <a class="delete-btn" href="#" onclick="confirmDelete(<?php echo $row['symptom_id']; ?>); return false;">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
<?php endif; ?>

<a href="manage.php" style="display:block; margin-top:10em">Back to Manage Page</a>

<!-- Modal -->
<div id="confirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index: 999;">
  <div style="background:white; padding: 20px; width: 350px; margin: 100px auto; border-radius: 8px; text-align: center;">
    <p>Are you sure you want to delete this symptom?</p>
    <form method="get">
      <input type="hidden" name="delete" id="deleteId">
      <button type="submit" style="background: red; color: white; padding: 8px 15px;">Yes, Delete</button>
      <button type="button" onclick="hideModal()" style="padding: 8px 15px;">Cancel</button>
    </form>
  </div>
</div>
<?php
include('footer.php')
?>
<!-- JavaScript -->
<script>
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

</script>

<script src="validateSym.js"></script>
</body>
</html>

<?php
include 'admin_navbar.php'; 
include 'dbcon.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch dropdown data
$diseases = $conn->query("SELECT * FROM diseases");
$symptoms = $conn->query("SELECT * FROM symptoms");

// Edit mode
$editMapping = null;
if (isset($_GET['edit'])) {
    $editId = intval($_GET['edit']);
    $result = $conn->query("SELECT * FROM sd_mapping WHERE sd_id = $editId");
    $editMapping = $result->fetch_assoc();
}

// Add or update mapping
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $disease_id = $_POST['disease_id'];
    
    // EDIT: One symptom only
    if (!empty($_POST['mapping_id'])) {
        $symptom_id = $_POST['symptom_id'];
        $id = intval($_POST['mapping_id']);
        $stmt = $conn->prepare("UPDATE sd_mapping SET disease_id = ?, symptom_id = ? WHERE sd_id = ?");
        $stmt->bind_param("iii", $disease_id, $symptom_id, $id);
        $_SESSION['message'] = "<div class='alert alert-success'>✅ Mapping updated successfully.</div>";
        $stmt->execute();
        $stmt->close();
    } else {
        // ADD: Multiple symptoms
        $symptom_ids = $_POST['symptom_id'];
        foreach ($symptom_ids as $symptom_id) {
            $check = $conn->prepare("SELECT * FROM sd_mapping WHERE disease_id = ? AND symptom_id = ?");
            $check->bind_param("ii", $disease_id, $symptom_id);
            $check->execute();
            $res = $check->get_result();
            if ($res->num_rows === 0) {
                $stmt = $conn->prepare("INSERT INTO sd_mapping (disease_id, symptom_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $disease_id, $symptom_id);
                $stmt->execute();
                $stmt->close();
            }
        }
        $_SESSION['message'] = "<div class='alert alert-success'>✅ Mappings added successfully.</div>";
    }

    header("Location: manage_mapping.php");
    exit();
}

// Delete mapping
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

   // Check if the mapping exists
    $check = $conn->query("SELECT * FROM sd_mapping WHERE sd_id = $id");

    if ($check && $check->num_rows > 0) {
        // Mapping exists, proceed to delete
        $delete = $conn->query("DELETE FROM sd_mapping WHERE sd_id = $id");

        if ($delete) {
            $_SESSION['message'] = "<div class='alert alert-success'>✅ Mapping deleted successfully.</div>";
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'>❌ Failed to delete the mapping.</div>";
        }
    } else {
        $_SESSION['message'] = "<div class='alert alert-warning'>⚠️ Mapping does not exist or has already been deleted.</div>";
    }

    header("Location: manage_mapping.php");
    exit();
}

// Fetch all mappings
$mappings = $conn->query("
    SELECT m.sd_id, d.disease_name, s.symptom_name 
    FROM sd_mapping m
    JOIN diseases d ON m.disease_id = d.disease_id
    JOIN symptoms s ON m.symptom_id = s.symptom_id
    ORDER BY d.disease_name, s.symptom_name
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptom Checker|Manage Mapping</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        select, button { width: 100%; padding: 10px; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color:white; }
        th, td { border: 1px solid #ccc; padding: 10px; }
        th { background: #f4f4f4; }
        .edit-btn { color: green; text-decoration: none; margin-right: 10px; }
        .delete-btn { color: red; text-decoration: none; }
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
.mbtn{
    margin-top: 0.5em;
    background-color:#007bff ;
    border:none;
    border-radius:2px;
    width:auto;
    float:left;
}
#toggleBtn{
    margin-top:0;
    margin-right:45%;
    margin-bottom: 1em;
    background-color:  #758ba3;
    width:auto;
    border:none;
    border-radius:2px;
    float:right;
   }
#toggleBtn:hover{
    background-color: #ccc;
   }
#symptom-list{
    display:none;
    margin-top:5%;
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
     include('admin_header.php');
     ?>
<body>

<h2><?php echo $editMapping ? "Edit Mapping" : "Add New Mapping"; ?></h2>


<form class="new-entry" method="post">
    <!-- notify -->
    
<?php if (isset($_SESSION['message'])): ?>
    <?php echo $_SESSION['message']; ?>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

    <?php if ($editMapping): ?>
        <input type="hidden" name="mapping_id" value="<?php echo $editMapping['sd_id']; ?>">
    <?php endif; ?>

    <label><b><i>Disease:</b></i></label>
    <select name="disease_id" style="margin-bottom:2em; border-radius:3px;" required>
        <option value="">Select Disease</option>
        <?php
        $diseases->data_seek(0); // reset pointer
        while ($row = $diseases->fetch_assoc()):
            $selected = ($editMapping && $editMapping['disease_id'] == $row['disease_id']) ? "selected" : "";
        ?>
            <option value="<?php echo $row['disease_id']; ?>" <?php echo $selected; ?>>
                <?php echo $row['disease_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
<?php if (!$editMapping): ?>
    <label><b><i>Symptoms (you can select multiple):</b></i></label>
    <select name="symptom_id[]" multiple size="5" style="margin-bottom:1em; border-radius:3px;" required>
        <option value="" style="font-weight:bold;">Select Symptom</option>
        <?php
        $symptoms->data_seek(0); // reset pointer
        while ($row = $symptoms->fetch_assoc()):
            $selected = ($editMapping && $editMapping['symptom_id'] == $row['symptom_id']) ? "selected" : "";
        ?>
            <option style="margin:0.5em;"value="<?php echo $row['symptom_id']; ?>" <?php echo $selected; ?>>
                <?php echo $row['symptom_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
        <?php else: ?>
    <label><b><i>Symptom:</b></i></label>
    <select name="symptom_id" required>
        <option value="">Select Symptom</option>
        <?php
        $symptoms->data_seek(0);
        while ($row = $symptoms->fetch_assoc()):
            $selected = ($editMapping && $editMapping['symptom_id'] == $row['symptom_id']) ? "selected" : "";
        ?>
            <option value="<?php echo $row['symptom_id']; ?>" <?php echo $selected; ?>>
                <?php echo $row['symptom_name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
<?php endif; ?>
    <button type="submit" id="add" class="mbtn"><?php echo $editMapping ? "Update Mapping" : "Add Mapping"; ?></button>
    <?php if ($editMapping): ?>
        <a href="manage_mapping.php" style="margin-left: 10px;">Cancel Edit</a>
    <?php endif; ?>
</form>

<!-- Show mapping list only if not editing -->
 <?php if (!isset($_GET['edit'])): ?>
<button onclick="toggleSymptomList()" id="toggleBtn" class="mbtn">Show Disease-Symptoms mapping List</button>
<?php endif; ?>
<?php if (!$editMapping): ?>
<div id="symptom-list">
<h3>Existing Mappings</h3>
  <div class="scrollable" style="overflow-x: auto;">
    <table>
        <tr>
            <th>Disease</th>
            <th>Symptom</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $mappings->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['disease_name']); ?></td>
                <td><?php echo htmlspecialchars($row['symptom_name']); ?></td>
                <td>
                    <a class="edit-btn" href="?edit=<?php echo $row['sd_id']; ?>">Edit</a>
                    <a class="delete-btn" href="#" onclick="confirmDelete(<?php echo $row['sd_id']; ?>); return false;">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
  </div>
</div>

<?php endif; ?>

<a href="manage.php" style="display:block; margin-top:10em;">Back to Manage Page</a>
<div id="confirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index: 999;">
  <div style="background:white; padding: 20px; width: 350px; margin: 100px auto; border-radius: 8px; text-align: center;">
    <p>Are you sure you want to delete this mapping?</p>
    <form method="get">
      <input type="hidden" name="delete" id="deleteId">
      <button type="submit" style="background: red; color: white; width: auto; padding: 8px 15px;">Yes, Delete</button>
      <button type="button" onclick="hideModal()" style="width: auto; padding: 8px 15px;">Cancel</button>
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
        btn.textContent = "Hide Disease-Symptom mapping List";
    } else {
        list.style.display = "none";
        btn.textContent = "Show Disease-Symptom List";
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
</body>
</html>

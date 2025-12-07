<?php
include 'menubar.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'dbcon.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['symptoms'])) {
    echo "<p style='color:red;'>Please select at least one symptom.</p>";
    exit();
}

$symptoms = $_POST['symptoms'];
$symptom_ids = implode(',', array_map('intval', $symptoms));

// Query matching diseases
$sql = "
    SELECT DISTINCT d.disease_id, d.disease_name, d.description, d.prevention
    FROM diseases d
    JOIN sd_mapping m ON d.disease_id = m.disease_id
    WHERE m.symptom_id IN ($symptom_ids)
    GROUP BY d.disease_id
    HAVING COUNT(DISTINCT m.symptom_id) = " . count($symptoms);

$results = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosis Results</title>
    <link rel="stylesheet" href="result.css">
    <?php include 'headers.php'; ?>
</head>

<body>

<h2>Possible Disease(s) Based on Your Symptoms</h2>

<?php
if ($results->num_rows > 0):
    while ($row = $results->fetch_assoc()):
        $disease_id = $row['disease_id'];
        $symptom_names = [];

        $symptom_query = $conn->query("
            SELECT s.symptom_name
            FROM sd_mapping m
            JOIN symptoms s ON m.symptom_id = s.symptom_id
            WHERE m.disease_id = $disease_id
              AND m.symptom_id IN ($symptom_ids)
        ");
        while ($s = $symptom_query->fetch_assoc()) {
            $symptom_names[] = $s['symptom_name'];
        }
?>

<div class="result-card">
    <h3><?php echo $row['disease_name']; ?></h3>

    <img src="assets/images/<?php echo strtolower($row['disease_name']); ?>.jpg"
         alt="Image of <?php echo $row['disease_name']; ?>"
         onerror="this.style.display='none';">

    <p><strong>Possible Condition:</strong> You may be experiencing symptoms related to <strong><?php echo $row['disease_name']; ?></strong>.</p>

    <p><strong>Description:</strong> <?php echo $row['description']; ?></p>

    <p><strong>Based on your input:</strong> You selected the following symptoms: <em><?php echo implode(', ', $symptom_names); ?></em>.</p>

    <p><strong>Recommended Action:</strong> You’ve to follow the <strong>prevention methods</strong> described below to protect yourself or reduce risk.</p>

    <p><strong>Prevention:</strong> <?php echo $row['prevention']; ?></p>

    <p class="note">Note: This result is for awareness purposes only. Please consult a health professional for accurate diagnosis and treatment.</p>
</div>

<?php
    endwhile;
else:
    // Show no match message
    echo <<<HTML
    <div class="no-result-box">
      <h3>No Matching Disease Found</h3>
      <p>We couldn’t find a result based on your selected symptoms. This could be due to:</p>
      <ul>
        <li>Uncommon symptom combinations</li>
        <li>A condition not included in our system</li>
      </ul>
      <p>💬 You can <strong>chat with our virtual assistant below</strong> for more personalized support.</p>
    </div>
HTML;
endif;
?>


<a href="index.php" class="back-link">👈Re-check Symptoms</a>
<a href="#" onclick="window.print();" class="print-btn">🖨️ Download/Print Result</a>

<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="ZrmrjYknPxrPCU_lxhCBz";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
<?php
include('footer.php');
// Close the database connection
$conn->close();
?>
</html>

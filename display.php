<?php
if ($result->num_rows >0) {
    echo'<h2>Possible Disease based on Symptoms you provided.</h2>';
    while ($row = $result->fetch_assoc()) {

        echo " <main>
        
        <div style='border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; margin-top: 15px;'>
               <div>
                <h3>{$row['disease_name']}</h3>
                <p>{$row['description']}</p>
                <h4>You can prevent, <em style='color:blue; background-color:yellow;'>{$row['disease_name']}</em></h4>
                <h5>{$row['prevention']}</h5>
              </div>
              </main>";
    }
} else {
    echo "<p>No diseases found matching your symptoms. Please try again.</p>";
}
?>
<a href="../index.php" style=" margin-bottom: 15px; width: 15%; border: 1px solid gray; border-radius:5px; display:block; margin-top:20px;">Re-check Symptoms</a>


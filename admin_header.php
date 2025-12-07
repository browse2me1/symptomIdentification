<!-- admin_header.php -->
<div class="header-bar">
  <img src="logo.png" alt="University Logo">
  <div class="system-title">Admin Panel – Symptom-Based Disease ID System</div>
</div>

<style>
  .header-bar {
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-bottom: 2px solid #007bff;
    flex-wrap: wrap;
  }

  .header-bar img {
    height: 60px;
  }

  .system-title {
    font-size: 1.4rem;
    font-weight: bold;
    color: #343a40;
    text-align: right;
    flex: 1;
    padding-left: 20px;
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

  @media (max-width: 600px) {
    .header-bar {
      flex-direction: column;
      text-align: center;
    }

    .system-title {
      padding-left: 0;
      font-size: 1.2rem;
    }

    .header-bar img {
      height: 50px;
      margin-bottom: 10px;
    }
  }
</style>

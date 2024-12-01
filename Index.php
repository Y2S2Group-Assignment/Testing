<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD with PHP and JavaScript</title>
</head>
<?php
    include './Connection/Conn.php';
?>
<body>
  <h1>Student Management</h1>

  <!-- Add Student Form -->
  <form id="studentForm">
    <input type="hidden" id="studentId">
    <input type="text" id="firstname" placeholder="First Name" required>
    <input type="text" id="lastname" placeholder="Last Name" required>
    <select id="genderId" required>
      <option value="" disabled selected>Select Gender</option>
      <option value="1">Male</option>
      <option value="2">Female</option>
    </select>
  
    <button type="submit">Save Student</button>
  </form>

  <!-- Student List -->
  <h2>Student List</h2>
  <table border="1">
    <thead>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
    
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="studentList"></tbody>
  </table>

 
</body>
</html>

<script src="./Template/Index.js"></script>

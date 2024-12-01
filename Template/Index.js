


console.log("hiiiiiiiiiiiiiiiiiiiiiii");

const studentForm = document.getElementById('studentForm');
const studentList = document.getElementById('studentList');

// Fetch and display students
async function fetchStudents() {
  try {
    const response = await fetch('./Action/Action.php');
    if (!response.ok) {
      const error = await response.json();
      console.error("Error fetching students:", error);
      alert(`Error: ${error.error || "Failed to fetch students."}`);
      return;
    }

    const students = await response.json();
    studentList.innerHTML = students.map(student => `
      <tr>
        <td>${student.id}</td>
        <td>${student.firstname}</td>
        <td>${student.lastname}</td>
        <td>${student.gender_id == 1 ? 'Male' : (student.gender_id == 2 ? 'Female' : 'Unknown')}</td>

        <td>
          <button onclick="editStudent(${student.id}, '${student.firstname}', '${student.lastname}', ${student.gender_id})">Edit</button>
          <button onclick="deleteStudent(${student.id})">Delete</button>
        </td>
      </tr>
    `).join('');
  } catch (err) {
    console.error("Fetch error:", err);
    alert("Failed to fetch students.");
  }
}

// Create or Update Student
studentForm.addEventListener('submit', async function(event) {
  event.preventDefault();

  const id = document.getElementById('studentId').value;
  const firstname = document.getElementById('firstname').value.trim();
  const lastname = document.getElementById('lastname').value.trim();
  const genderId = document.getElementById('genderId').value;

  if (!firstname || !lastname || !genderId) {
    alert("Please fill in all required fields.");
    return;
  }

  const student = { firstname, lastname, gender_id: genderId };

  try {
    let response;
    if (id) {
      student.id = id;
      response = await fetch('./Action/Action.php', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(student),
      });
    } else {
      response = await fetch('./Action/Action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(student),
      });
    }

    if (!response.ok) {
      const error = await response.json();
      console.error("Error:", error);
      alert(`Error: ${error.error || "Failed to save student."}`);
    } else {
      fetchStudents();
    }
  } catch (err) {
    console.error("Fetch error:", err);
    alert("Failed to connect to the server.");
  }

  studentForm.reset();
});

// Edit Student
function editStudent(id, firstname, lastname, genderId) {
  document.getElementById('studentId').value = id;
  document.getElementById('firstname').value = firstname;
  document.getElementById('lastname').value = lastname;
  document.getElementById('genderId').value = genderId;
}

// Delete Student
async function deleteStudent(id) {
  try {
    const response = await fetch(`./Action/Action.php?id=${id}`, { method: 'DELETE' });
    if (!response.ok) {
      const error = await response.json();
      console.error("Error:", error);
      alert(`Error: ${error.error || "Failed to delete student."}`);
    } else {
      fetchStudents();
    }
  } catch (err) {
    console.error("Fetch error:", err);
    alert("Failed to connect to the server.");
  }
}

// Initial Fetch
fetchStudents();


<?php
include '../Connection/Conn.php';
header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Fetch all students
        $result = $conn->query("SELECT * FROM tbl_student");
        $students = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($students);
        break;

    case 'POST':
        // Create a new student
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("INSERT INTO tbl_student (firstname, lastname, gender_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $data['firstname'], $data['lastname'], $data['gender_id']);
        $stmt->execute();
        echo json_encode(["id" => $conn->insert_id]);
        break;

    case 'PUT':
        // Update student
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("UPDATE tbl_student SET firstname = ?, lastname = ?, gender_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $data['firstname'], $data['lastname'], $data['gender_id'], $data['id']);
        $stmt->execute();
        echo json_encode(["success" => "Student updated successfully"]);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $conn->prepare("DELETE FROM tbl_student WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            echo json_encode(["success" => "Student deleted successfully"]);
        } else {
            echo json_encode(["error" => "No ID provided"]);
        }
        break;

    default:
        echo json_encode(["error" => "Method not allowed"]);
        break;
}
?>

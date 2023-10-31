<?php
// Database connection
$host = 'localhost'; // Change to your database host
$username = 'Amina'; // Change to your database username
$password = 'Myna1234!'; // Change to your database password
$database = 'task_manager';

$conn = mysqli_connect('localhost', 'root', " ", 'task_manager');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to create a new task
function createTask($task_name, $status) {
    global $conn;
    $task_name = mysqli_real_escape_string($conn, $task_name);
    $status = mysqli_real_escape_string($conn, $status);

    $sql = "INSERT INTO tasks (task_name, status) VALUES ('$task_name', '$status')";
    return mysqli_query($conn, $sql);
}

// Function to retrieve and display a list of all tasks
function getTasks() {
    global $conn;
    $sql = "SELECT * FROM tasks";
    $result = mysqli_query($conn, $sql);
    $tasks = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
    return $tasks;
}

// Function to update the status or description of a task
function updateTask($id, $task_name, $status) {
    global $conn;
    $id = (int)$id;
    $task_name = mysqli_real_escape_string($conn, $task_name);
    $status = mysqli_real_escape_string($conn, $status);

    $sql = "UPDATE tasks SET task_name='$task_name', status='$status' WHERE id=$id";
    return mysqli_query($conn, $sql);
}

// Function to delete a task
function deleteTask($id) {
    global $conn;
    $id = (int)$id;

    $sql = "DELETE FROM tasks WHERE id=$id";
    return mysqli_query($conn, $sql);
}

// Handle POST requests for task operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create') {
            $task_name = $_POST['task_name'];
            $status = $_POST['status'];
            createTask($task_name, $status);
        } elseif ($_POST['action'] === 'update') {
            $id = $_POST['id'];
            $task_name = $_POST['task_name'];
            $status = $_POST['status'];
            updateTask($id, $task_name, $status);
        } elseif ($_POST['action'] === 'delete') {
            $id = $_POST['id'];
            deleteTask($id);
        }
    }
}

// Retrieve and display tasks
$tasks = getTasks();
?>

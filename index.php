<?php

require __DIR__ . "/config.php";

// Add a task
if($_POST['taskAction'] == 'create') {
    $taskName = $_POST['taskName'];

    if(strlen($taskName) > 0) {
        $query = $db->prepare("INSERT INTO tasks (name) VALUES ('{$taskName}')");
        $query->execute();
    }
}

// Delete a task
if($_POST['taskAction'] == 'delete') {
    $taskId = $_POST['taskId'];

    $query = $db->prepare("DELETE FROM tasks WHERE id={$taskId}");
    $query->execute();
}

// Complete a task
if($_POST['taskAction'] == 'markCompleted') {
    $taskId = $_POST['taskId'];
    $completed = ($_POST['completed'] == "0") ? "1" : "0";

    $query = $db->prepare("UPDATE tasks SET completed={$completed} WHERE id={$taskId}");
    $query->execute();
}

$query = $db->prepare("SELECT * FROM tasks");
$query->execute();
$tasks = $query->fetchAll(PDO::FETCH_OBJ);

echo $blade->make('homepage', ['tasks' => $tasks]);

<?php

require __DIR__ . "/config.php";

// Add a task
if($_POST['taskAction'] == 'create') {
    $taskName = $_POST['taskName'];

    if(strlen($taskName) > 0) {
        $query = $db->prepare("INSERT INTO tasks (name) VALUES ('{$taskName}')");
        $query->execute();

        if($_POST['ajax'] === '1') {
            $data = new stdClass();
            // get newly created taskId from database
            $data->taskId = $taskId;
            $data->name = $taskName;
            $data->taskAction = $_POST['taskAction'];

            echo json_encode($data);
            return;
        }
    }
}

// Delete a task
if($_POST['taskAction'] == 'delete') {
    $taskId = $_POST['taskId'];

    $query = $db->prepare("DELETE FROM tasks WHERE id={$taskId}");
    $query->execute();

    if($_POST['ajax'] === '1') {
        $data = new stdClass();
        $data->taskId = $taskId;
        $data->taskAction = $_POST['taskAction'];

        echo json_encode($data);
        return;
    }
}

// Complete a task
if($_POST['taskAction'] == 'markCompleted') {
    $taskId = $_POST['taskId'];
    $completed = ($_POST['completed'] == "0") ? "1" : "0";

    $query = $db->prepare("UPDATE tasks SET completed={$completed} WHERE id={$taskId}");
    $query->execute();

    if($_POST['ajax'] === '1') {
        $data = new stdClass();
        $data->taskId = $taskId;
        $data->taskAction = $_POST['taskAction'];
        $data->completed = $completed;

        echo json_encode($data);
        return;
    }
}

$query = $db->prepare("SELECT * FROM tasks");
$query->execute();
$tasks = $query->fetchAll(PDO::FETCH_OBJ);

echo $blade->make('homepage', ['tasks' => $tasks]);

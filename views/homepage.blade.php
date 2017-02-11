<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo App</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container app">
        <h1 class="app-title">Todo App</h1>
        <form class="todo-form" action="index.php" method="POST">
            <input type="hidden" name="taskAction" value="create">
            <div class="form-group">

                <!-- Add Task -->
                <div class="input-group">
                    <input type="text" name="taskName" class="form-control" placeholder="Do the dishes">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </span>
                </div>

            </div>
        </form>
        <hr>
        @if (count($tasks) > 0)
            <ul class="list-group">
                @foreach ($tasks as $task)
                    <li class="task list-group-item">
                        @if ($task->completed)
                            <span class="task-name completed">{{ $task->name }}</span>
                        @else
                            <span class="task-name">{{ $task->name }}</span>
                        @endif
                        <div class="task-forms-container">
                            <form class="task-form" action="index.php" method="POST">
                                <input type="hidden" name="taskAction" value="markCompleted">
                                <input type="hidden" name="taskId" value={{ $task->id }}>
                                <input type="hidden" name="completed" value={{ $task->completed }}>
                                <button class="btn btn-primary delete-btn" type="submit" name="button">
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                </button>
                            </form>

                            <form class="task-form" action="index.php" method="POST">
                                <input type="hidden" name="taskAction" value="delete">
                                <input type="hidden" name="taskId" value={{ $task->id }}>
                                <button class="btn btn-danger delete-btn" type="submit" name="button">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>

                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>

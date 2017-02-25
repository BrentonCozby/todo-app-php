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
        <form class="todo-form add-task-form" action="index.php" method="POST">
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
            <ul class="list-group task-list">
                @foreach ($tasks as $task)
                    <li data-taskId={{ $task->id }} class="task list-group-item">
                        <div class="input-group">
                            <form class="task-name-form" action="index.php" method="POST">
                                <input type="hidden" name="taskAction" value="markCompleted">
                                <input type="hidden" name="taskId" value={{ $task->id }}>
                                <input type="hidden" name="completed" value={{ $task->completed }}>
                                <button class="task-name-btn" type="submit" name="button">
                                    @if ($task->completed)
                                        <span data-taskId={{ $task->id }} class="task-name completed">{{ $task->name }}</span>
                                    @else
                                        <span data-taskId={{ $task->id }} class="task-name">{{ $task->name }}</span>
                                    @endif
                                </button>
                            </form>
                            <span class="input-group-btn">
                                <form class="task-delete-form" action="index.php" method="POST">
                                    <input type="hidden" name="taskAction" value="delete">
                                    <input type="hidden" name="taskId" value={{ $task->id }}>
                                    <button class="btn btn-danger task-btn" type="submit" name="button">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script type="text/javascript">

        function createNewTask(taskId, name) {
            return `
                <li data-taskId="${taskId}" class="task list-group-item">
                    <div class="input-group">
                        <form class="task-name-form" action="index.php" method="POST">
                            <input type="hidden" name="taskAction" value="markCompleted">
                            <input type="hidden" name="taskId" value=${taskId}>
                            <input type="hidden" name="completed" value="0">
                            <button class="task-name-btn" type="submit" name="button">
                                <span data-taskId="${taskId}" class="task-name">${name}</span>
                            </button>
                        </form>
                        <span class="input-group-btn">
                            <form class="task-delete-form" action="index.php" method="POST">
                                <input type="hidden" name="taskAction" value="delete">
                                <input type="hidden" name="taskId" value=${taskId}>
                                <button class="btn btn-danger task-btn" type="submit" name="button">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </button>
                            </form>
                        </span>
                    </div>
                </li>
            `
        }

        function handleFormResponse(data) {
            if(data.taskAction === 'markCompleted') {
                const taskListItem = document.querySelector(`li[data-taskId="${data.taskId}"]`)
                const completedInput = taskListItem.querySelector('input[name="completed"]')
                completedInput.value = (completedInput.value == '1') ? '0' : '1'

                const taskName = document.querySelector(`.task-name[data-taskId="${data.taskId}"]`)
                taskName.classList.toggle('completed')
            }
            if(data.taskAction === 'delete') {
                const taskListItem = document.querySelector(`li[data-taskId="${data.taskId}"]`)
                document.querySelector('.task-list').removeChild(taskListItem)
            }
            if(data.taskAction === 'create') {
                document.querySelector('.task-list').appendChild(
                    createNewTask(data.taskId, data.name)
                )
            }
        }

        function sendForm(e) {
            e.preventDefault()
            $.ajax({
                url: 'index.php',
                type: 'POST',
                dataType: 'json',
                data: $(event.target).serialize() + '&ajax=1'
            })
            .done(handleFormResponse)
        }

        $('.task-name-form, .task-delete-form, .add-task-form').submit(sendForm)

    </script>
</body>
</html>

<?php


require_once __DIR__ . '/vendor/autoload.php';
use App\Handlers\SelectItem

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To-Do App</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="./assets/scripts/ajax.js"></script>
  <link rel="stylesheet" href="./assets/styles/home.css">
</head>

<body>

  <h1 class="todo-title">TO-DO-LIST</h1>

  <section class="todo-list unmarked-list">
    <div class="container">
      <div class="todo-list-wrapper">
        <h2 class="section-title">Tasks Needs To be Done</h2>
        <?php
        $select_item = new SelectItem();
        $data_todo = $select_item->select_todo_item();
        if (!empty($data_todo)) {
          foreach ($data_todo['todo'] as $todo_list) {
            echo '<div class="individual-todo-item">';
            echo '<h3 class="todo-name">' . $todo_list['name'] . '</h3>';
            echo '<h3 class="todo-date">' . $todo_list['date'] . '</h3>';
            echo '<div class="todo-buttons">';
            echo '<a class="edit-todo">Edit</a>';
            echo '<a class="delete-todo">Delete</a>';
            echo '<a class="mark-todo" href="/app/Handlers/MarkItem.php?q=' . $todo_list['date'] . '">Mark</a>';
            echo ' </div>';
            echo '<form method="post" action="/app/Handlers/EditItem.php" class="todo-edit-form">';
            echo '<input type="text" placeholder="New Todo Name" name="edit_name">';
            echo '<input type="text" placeholder="Add Todo" name="date_time" disabled value="' . $todo_list['date'] . '">';
            echo '<input type="submit" value="Edit Todo">';
            echo '</form>';
            echo '</div>';
          }
        }
        ?>
      </div>
    </div>
  </section>

  <section class="todo-list marked-list">
    <div class="container">
      <div class="todo-list-wrapper">
        <h2 class="section-title">Tasks Done</h2>
        <?php
        $data_done = $select_item->select_done_item();
        if (!empty($data_done)) {
          foreach ($data_done['todo'] as $todo_list) {
            echo '<div class="individual-todo-item done-list">';
            echo '<h3 class="todo-name">' . $todo_list['name'] . '</h3>';
            echo '<h3 class="todo-date">' . $todo_list['date'] . '</h3>';
            echo '<div class="todo-buttons">';
            echo '<a class="edit-todo">Edit</a>';
            echo '<a class="delete-todo">Delete</a>';
            echo '<a class="mark-todo" href="/app/Handlers/MarkItem.php?q=' . $todo_list['date'] . '">Mark</a>';
            echo ' </div>';
            echo '<form method="post" action="/app/Handlers/EditItem.php" class="todo-edit-form">';
            echo '<input type="text" placeholder="New Todo Name" name="edit_name">';
            echo '<input type="text" placeholder="Add Todo" name="date_time" disabled value="' . $todo_list['date'] . '">';
            echo '<input type="submit" value="Edit Todo">';
            echo '</form>';
            echo '</div>';
          }
        }
        ?>
      </div>
    </div>
  </section>


  <section class="add-todo">
    <form method="post" action="/app/Handlers/AddItem.php" id="todo-form">
      <input type="text" placeholder="Add Todo" name="new_todo">
      <input type="submit" value="Submit Todo">
    </form>
  </section>

</body>

</html>
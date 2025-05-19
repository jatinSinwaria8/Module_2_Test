$(document).ready(function () {
  $(".todo-edit-form").hide();
});

$(document).ready(function () {
  $("#todo-form").submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const newTodo = `
            <div class="individual-todo-item">
              <h3 class="todo-name">${response.todo.name}</h3>
              <h3 class="todo-date">${response.todo.date_time}</h3>
              <div class="todo-buttons">
                <a class="edit-todo">Edit</a>
                <a class="delete-todo>Delete</a>
                <a class="mark-todo" href="/app/Handlers/MarkItem.php?q=${response.todo.date_time}">Mark</a>
              </div>
            </div>`;
          $(".unmarked-list .todo-list-wrapper").append(newTodo);
          $("#todo-form")[0].reset();
        } else {
          alert("Failed to add to-do.");
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", error);
      },
    });
  });
});

$(document).on("click", ".delete-todo", function () {
  let this_button = $(this);
  let this_individual_todo = this_button.closest(".individual-todo-item");
  let this_todo_date = this_individual_todo.find(".todo-date");

  $.ajax({
    url: "/app/Handlers/DeleteItem.php",
    type: "POST",
    data: {
      date_time: this_todo_date.text(),
    },
    success: function (response) {
      if (response.button === "delete") {
        this_individual_todo.hide();
      }
    },
  });
});

$(document).on("click", ".edit-todo", function () {
  let this_button = $(this);
  let this_individual_todo = this_button.closest(".individual-todo-item");
  let this_todo_form = this_individual_todo.find(".todo-edit-form");
  let this_todo_name = this_individual_todo.find(".todo-name");
  this_todo_form.show();
});

// $(document).on("click", ".edit-todo", function () {
//   let this_button = $(this);
//   let this_individual_todo = this_button.closest(".individual-todo-item");
//   let this_todo_form = this_individual_todo.find(".todo-edit-form");
//   let this_todo_name = this_individual_todo.find(".todo-name");
//   this_todo_form.show();

//   this_todo_form.submit(function (e) {
//     e.preventDefault();
//     $.ajax({
//       type: "POST",
//       url: $(this).attr("action"),
//       data: $(this).serialize(),
//       dataType: "json",
//       success: function (response) {
//         if (response.status === "success") {
//           text = response.todo.name;
//           this_todo_name.text(text);
//         } else {
//           alert("Failed to add to-do.");
//         }
//       },
//       error: function (xhr, status, error) {
//         console.error("AJAX error:", error);
//       },
//     });
//   });
// });

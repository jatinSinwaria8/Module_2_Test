<?php
namespace App\Handlers;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Database;


/**
 * Edit item to edit todo list item.
 */
class EditItem extends Database
{
  /**
   * @var string
   * Todo list table name.
   */
  private $table_name = 'todo_list';

  /**
   * Function to edit todo name.
   * @param mixed $todo_name
   * @param mixed $todo_date_time
   * @return void
   */
  public function edit_item($todo_name, $todo_date_time)
  {
    $stmt = $this->con->prepare("UPDATE $this->table_name 
      SET todo_name = ? 
      WHERE todo_date_time = ?");

    $stmt->bind_param("ss", $todo_name, $todo_date_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

  }
}

/**
 * Datarefine function to refine data.
 * @param mixed $data
 * @return string
 */
function datarefine($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $todo_name = $_POST['edit_name'];
  $todo_date_time = $_POST['date_time'];

  $edit_item = new EditItem();
  $edit_item->edit_item($todo_name, $todo_date_time);

  header("Location: /index.php");

  // Return JSON success response
  // echo json_encode([
  //   "status" => "success",
  //   "todo" => [
  //     "name" => $todo_name,
  //   ]
  // ]);
  // exit;

}
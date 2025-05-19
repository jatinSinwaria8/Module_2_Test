<?php
namespace App\Handlers;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Database;

/**
 * AddItem to add new item to list.
 */
class AddItem extends Database
{
  /**
   * Todo list table name.
   * @var string
   */
  private $table_name = 'todo_list';

  /**
   * Function to add new item to list.
   * @param mixed $todo_id
   * @param mixed $todo_name
   * @param mixed $todo_date_time
   * @return void
   */
  public function add_item($todo_id, $todo_name, $todo_date_time)
  {
    $false = 0;
    $sql = "
      CREATE TABLE IF NOT EXISTS $this->table_name
      (todo_id VARCHAR(255) PRIMARY KEY,
        todo_name VARCHAR(255),
        todo_status INT,
        todo_date_time DATETIME
        )";

    $this->create_table_if_not_exist($this->table_name, $sql);

    $stmt = $this->con->prepare("INSERT INTO $this->table_name (todo_id, todo_name,todo_status, todo_date_time) VALUES (?, ?,?, ?)");

    $stmt->bind_param("ssis", $todo_id, $todo_name, $false, $todo_date_time);
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

  $todo_name = datarefine($_POST['new_todo']);

  // setting the timezone to Asia/Kolkata
  date_default_timezone_set("Asia/Kolkata");

  /**
   * @var string $todo_date to get the current date
   */
  $todo_date = date("d/m/Y");

  /**
   * @var string $todo_time to get the current time
   */
  $todo_time = date("H/i/s");

  /**
   * @var string $todo_date_time to get the current date and time
   */
  $todo_date_time = date("Y-m-d H:i:s");

  /**
   * @var string $todo_id to create a unique post id
   */
  $todo_id = "/" . $todo_date . "/" . $todo_time;

  $add_item = new AddItem();
  $add_item->add_item($todo_id, $todo_name, $todo_date_time);


  // Return JSON success response
  echo json_encode([
    "status" => "success",
    "todo" => [
      "name" => $todo_name,
      "id" => $todo_id,
      "date_time" => $todo_date_time
    ]
  ]);
  exit;

}


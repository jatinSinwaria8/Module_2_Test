<?php
namespace App\Handlers;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Database;

/**
 * MarkItem to mark done any list item.
 */
class MarkItem extends Database
{
  /**
   * Todo_list table.
   * @var string
   */
  private $table_name = 'todo_list';

  /**
   * Function to mark task done or undone .
   * @param mixed $todo_date_time
   * @return void
   */
  public function mark_item($todo_date_time)
  {
    $stmt = $this->con->prepare("SELECT todo_status FROM $this->table_name
      WHERE todo_date_time = ?");
    $stmt->bind_param("s", $todo_date_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $status = $row['todo_date_time'];
    $stmt->close();

    if ($status) {
      $status--;
    } else {
      $status++;
    }

    $stmt = $this->con->prepare("UPDATE $this->table_name 
      SET todo_status = ? 
      WHERE todo_date_time = ?");
    $stmt->bind_param("ss", $status, $todo_date_time);
    $stmt->execute();
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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  $todo_date_time = $_GET['q'];

  $mark_item = new MarkItem();
  $mark_item->mark_item($todo_date_time);

  header("Location: /index.php");

}
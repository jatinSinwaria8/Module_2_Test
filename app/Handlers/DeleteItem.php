<?php
namespace App\Handlers;
require_once __DIR__ . '/../../vendor/autoload.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Database;


class DeleteItem extends Database
{
  private $table_name = 'todo_list';

  public function delete_item($todo_date_time)
  {
    $stmt = $this->con->prepare("DELETE FROM $this->table_name 
      WHERE todo_date_time = ?");

    $stmt->bind_param("s", $todo_date_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

  }
}

function datarefine($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $todo_date_time = $_POST['date_time'];

  $delete_item = new DeleteItem();
  $delete_item->delete_item($todo_date_time);

  header('Content-Type: application/json');
  echo json_encode(["button" => "delete"]);

}
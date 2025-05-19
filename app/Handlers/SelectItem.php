<?php
namespace App\Handlers;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Database;

/**
 * SelectItem to display list.
 */
class SelectItem extends Database
{
  private $table_name = 'todo_list';

  public function select_todo_item()
  {
    $sql = "
      CREATE TABLE IF NOT EXISTS $this->table_name
      (todo_id VARCHAR(255) PRIMARY KEY,
        todo_name VARCHAR(255),
        todo_status INT,
        todo_date_time DATETIME
        )";

    $this->create_table_if_not_exist($this->table_name, $sql);


    $data = [];

    $sql = "
      SELECT * from $this->table_name
      WHERE todo_status = 0
      ORDER BY todo_date_time ASC
    ";

    $result = $this->con->query($sql);

    while ($row = $result->fetch_assoc()) {
      $data['todo'][$row['todo_id']]['id'] = $row['todo_id'];
      $data['todo'][$row['todo_id']]['name'] = $row['todo_name'];
      $data['todo'][$row['todo_id']]['date'] = $row['todo_date_time'];
    }
    return $data;

  }

  /**
   * To display done tasks list.
   * @return array[][]
   */
  public function select_done_item()
  {
    $data = [];

    $sql = "
      SELECT * from $this->table_name
      WHERE todo_status = 1
      ORDER BY todo_date_time ASC
    ";

    $result = $this->con->query($sql);

    while ($row = $result->fetch_assoc()) {
      $data['todo'][$row['todo_id']]['id'] = $row['todo_id'];
      $data['todo'][$row['todo_id']]['name'] = $row['todo_name'];
      $data['todo'][$row['todo_id']]['date'] = $row['todo_date_time'];
    }
    return $data;

  }
}

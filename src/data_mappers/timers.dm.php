<?php
  require_once('data_mapper.php');
  require_once(SRC_DIR . '/domain_objects/timer.php');

  class TimersDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function create_for_student($student_id) {
      try {
        $sql = 'INSERT INTO timers
                  (student_id, subject_id, time_left, is_running, is_in_working_mode)
                VALUES (:student_id, NULL, 1500, 0, 1)';

        $query = $this->handler->prepare($sql);
        $query->execute([':student_id' => $student_id]);

        return true;
      } catch (PDOException $e) {
        echo $e;
        return false;
      }
    }

    public function get_for_student($student_id) {
      try {
        $sql = 'SELECT * FROM timers
                WHERE student_id = :student_id
                LIMIT 1';

        $query = $this->handler->prepare($sql);

        $query->execute([':student_id' => $student_id]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'Timer');

        return $query->fetch();
      } catch (PDOException $e) {
        echo $e;
      }
    }

    public function update_for_student($student_id, $new_timer) {
      try {
        $current_timer = $this->get_for_student($student_id);

        $updates_required = [];

        $sql = 'UPDATE timers SET ';

        if ($new_timer->subject_id !== $current_timer->subject_id) {
          $sql_extract = 'subject_id = :subject_id';
          $sql .= count($updates_required) !== 0 ? ', ' . $sql_extract : $sql_extract;
          $updates_required['subject_id']['sql_extract'] = $sql_extract;
          $updates_required['subject_id']['value'] = $new_timer->subject_id;
        } if ($new_timer->time_left !== $current_timer->time_left) {
          $sql_extract = 'time_left = :time_left';
          $sql .= count($updates_required) !== 0 ? ', ' . $sql_extract : $sql_extract;
          $updates_required['time_left']['sql_extract'] = $sql_extract;
          $updates_required['time_left']['value'] = $new_timer->time_left;
        } if ($new_timer->is_running !== $current_timer->is_running) {
          $sql_extract = 'is_running = :is_running';
          $sql .= count($updates_required) !== 0 ? ', ' . $sql_extract : $sql_extract;
          $updates_required['is_running']['sql_extract'] = $sql_extract;
          $updates_required['is_running']['value'] = $new_timer->is_running;
        } if ($new_timer->is_in_working_mode !== $current_timer->is_in_working_mode) {
          $sql_extract = 'is_in_working_mode = :is_in_working_mode';
          $sql .= count($updates_required) !== 0 ? ', ' . $sql_extract : $sql_extract;
          $updates_required['is_in_working_mode']['sql_extract'] = $sql_extract;
          $updates_required['is_in_working_mode']['value'] = $new_timer->is_in_working_mode;
        }

        if (!$updates_required) {
          return;
        }

        $prepared_array = [];

        foreach ($updates_required as $name => $update_required) {
          $prepared_array[':' . $name] = $update_required['value'];
        }
        $prepared_array[':student_id'] = $current_timer->student_id;

        $sql .= ' WHERE student_id = :student_id;';

        $query = $this->handler->prepare($sql);
        $query->execute($prepared_array);

      } catch (PDOException $e) {
        echo $e;
      }
    }
  }
?>

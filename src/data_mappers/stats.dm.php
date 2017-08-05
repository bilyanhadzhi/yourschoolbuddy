<?php
  require_once('data_mapper.php');

  class StatsDM extends DataMapper {
    public function __construct() {
      parent::__construct();
    }

    public function get_daily_time_studied_for_student($student_id, $range_start, $range_end) {
      try {
        $range_start = new DateTime($range_start);
        $range_end = (new DateTime($range_end))->modify('tomorrow');

        $sql = 'SELECT * FROM study_sessions
                WHERE student_id = :student_id
                  AND end_date IS NOT NULL
                  AND start_date > :range_start
                  AND end_date < :range_end';

        $query = $this->handler->prepare($sql);

        $query->execute([
          ':student_id' => $student_id,
          ':range_start' => $range_start->format('Y-m-d H:i:s'),
          ':range_end' => $range_end->format('Y-m-d H:i:s'),
        ]);

        $range_end->modify('yesterday');

        $query->setFetchMode(PDO::FETCH_OBJ);
        $study_sessions = $query->fetchAll();

        $num_of_days_in_range = $range_end->diff($range_start)->format("%a");
        $num_of_days_in_range_left = $num_of_days_in_range;
        $labels = [];

        while ($num_of_days_in_range_left >= 0) {
          $date = new DateTime($range_end->format('Y-m-d H:i:s'));

          $date->modify('-' . $num_of_days_in_range_left . ' days');

          $labels[$date->format('Y-m-d')] = 0;

          $num_of_days_in_range_left -= 1;
        }

        $minutes_studied = 0;

        // TODO: account for sessions that span over two days
        foreach ($study_sessions as $study_session) {
          $minutes_studied_current_session = abs(strtotime($study_session->start_date) - strtotime($study_session->end_date)) / 60;
          $date = new DateTime($study_session->end_date);

          $labels[$date->format('Y-m-d')] += $minutes_studied_current_session;
        }

        return $labels;
      } catch (PDOException $e) {
        echo $e;
      }
    }
  }
?>

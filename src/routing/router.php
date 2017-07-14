<?php
  class Router {
    private $url_params;
    private $url_params_len;
    private $flash_classes;

    public static $FLASH_RED = 'flash-red';
    public static $FLASH_GREEN = 'flash-green';
    public static $FLASH_BLUE = 'flash-blue';

    public static $AVAILABLE_ROUTES = [
      '', 'log_in', 'log_out', 'register','add_exam', 'edit_exam', 'delete_exam',
      'begin_study_session', 'end_study_session'
    ];

    public function set_current_url($url) {
      $this->url_params = $url === '' ? [''] : explode('/', rtrim($url, '/'));
      $this->url_params_len = count($this->url_params);
    }

    public function get_from_current_url() {
      $first_param = $this->url_params[0];

      if (!in_array($first_param, self::$AVAILABLE_ROUTES)) {
        $this->page_not_found();
        exit;
      }

      switch($this->url_params[0]) {
        case '':
          $this->not_one_param() ? $this->page_not_found() : $this->load('/home.php', true);
          break;
        case 'log_in':
          $this->not_one_param() ? $this->page_not_found() : $this->load('/log_in.php', false);
          break;
        case 'log_out':
          $this->not_one_param() ? $this->page_not_found() : $this->load('/log_out.php', true);
          break;
        case 'register':
          $this->not_one_param() ? $this->page_not_found() : $this->load('/register.php', false);
          break;
        case 'add_exam':
          $this->not_one_param() ? $this->page_not_found() : $this->load('/add_exam.php', true);
          break;
        case 'edit_exam':
          if (count($this->url_params) > 2) {
            $this->page_not_found();
            exit;
          }
          $params = count($this->url_params) === 2 ? ['exam_id' => $this->url_params[1]] : null;
          $this->load('/edit_exam.php', true, $params);
          break;
        case 'delete_exam':
          $this->not_one_param() ? $this->page_not_found() : $this->load('/delete_exam.php', true);
          break;
        case 'begin_study_session':
          $this->not_one_param() ? $this->page_not_found() : $this->load('/begin_study_session.php', true);
          break;
        case 'end_study_session':
          $this->not_one_param() ? $this->page_not_found() : $this->load('/end_study_session.php', true);
          break;
        default:
          $this->page_not_found();
      }
    }

    public function redirect_to($url, $messages = null, $messages_class = null) {
      if (isset($messages)) {
        $_SESSION['messages'] = $messages;

        if (isset($messages_class)) {
          $_SESSION['messages_class'] = $messages_class;
        }
      }

      header('Location: ' . ROOT_URL . $url);
    }

    public function load($page_name, $protected, $params = NULL) {
      $is_logged_in = isset($_SESSION['student_id']);

      if (($page_name === '/log_in.php' || $page_name === '/register.php') && $is_logged_in) {
        $this->redirect_to('/');
        exit;
      } elseif (!$protected) {
        require_once(SRC_DIR . '/controllers' . $page_name);
        exit;
      } elseif (!$is_logged_in) {
        $this->redirect_to('/log_in');
        exit;
      } else {
        if (isset($params)) {
          $params = $params;
        }
        require_once(SRC_DIR . '/controllers' . $page_name);
        exit;
      }
    }

    public function page_not_found() {
      http_response_code(404);
   // TODO: $this->load('/not_found.php, false');
      echo '404 Error: Page not found';
      exit;
    }

    private function not_one_param() {
      return $this->url_params_len > 1;
    }

    public function get_current_url() {
      return implode('/', $this->url_params);
    }
  }
?>

<?php
  class Router {
    private $url_params;
    private $url_params_len;

    public function set_current_url($url) {
      $this->url_params = $url === '' ? [''] : explode('/', rtrim($url, '/'));
      $this->url_params_len = count($this->url_params);
    }

    public function get_from_current_url() {
      switch($this->url_params[0]) {
        case '':
          $this->not_one_param() ? $this->page_not_found() : $this->get('/home.php', true);
          break;
        case 'log_in':
          $this->not_one_param() ? $this->page_not_found() : $this->get('/log_in.php', false);
          break;
        case 'log_out':
          $this->not_one_param() ? $this->page_not_found() : $this->get('/log_out.php', true);
          break;
        case 'register':
          $this->not_one_param() ? $this->page_not_found() : $this->get('/register.php', false);
          break;
        case 'add_exam':
          $this->not_one_param() ? $this->page_not_found() : $this->get('/add_exam.php', true);
          break;
        case 'delete_exam':
          $this->not_one_param() ? $this->page_not_found() : $this->get('/delete_exam.php', true);
          break;
        default:
          $this->page_not_found();
      }
    }

    public function redirect_to($url) {
      header('Location: ' . ROOT_URL . $url);
    }

    public function redirect_to_with_data($url, $data) {
      $_SESSION['data'] = $data;

      $this->redirect_to($url);
    }

    public function get($page_name, $protected) {
      $is_logged_in = isset($_SESSION['username']);

      if (($page_name === '/log_in.php' || $page_name === '/register.php') && $is_logged_in) {
        $this->redirect_to('/');
        exit;
      } elseif (!$protected) {
        require_once(SRC_DIR . $page_name);
        exit;
      } elseif (!$is_logged_in) {
        $this->redirect_to('/log_in');
        exit;
      } else {
        require_once(SRC_DIR . $page_name);
        exit;
      }
    }

    public function page_not_found() {
      http_response_code(404);
      echo '404 Error: Page not found';
      exit;
    }

    private function not_one_param() {
      return $this->url_params_len > 1;
    }

    public function get_url_params() {
      return $this->url_params;
    }
  }
?>

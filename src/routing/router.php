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
          $this->url_params_len > 1 ? $this->page_not_found() : $this->get('/home.php', true);
          break;
        case 'log_in':
          $this->url_params_len > 1 ? $this->page_not_found() : $this->get('/log_in.php', false);
          break;
        case 'log_out':
          $this->url_params_len > 1 ? $this->page_not_found() : $this->get('/log_out.php', true);
          break;
        case 'register':
          $this->url_params_len > 1 ? $this->page_not_found() : $this->get('/register.php', false);
          break;
        default:
          $this->page_not_found();
      }
    }

    public function redirect_to($url) {
      header('Location: ' . ROOT_URL . $url);
    }

    public function get($page_name, $protected) {
      $is_logged_in = isset($_SESSION['username']);

      if (($page_name === '/log_in.php' || $page_name === '/register.php') && $is_logged_in) {
        $this->redirect_to('/');
      } elseif (!$protected) {
        require_once(SRC_DIR . $page_name);
        exit;
      } elseif (!$is_logged_in) {
        $this->redirect_to('/log_in');
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

    public function get_url_params() {
      return $this->url_params;
    }

    public function get_url_params_length() {
      return $this->url_params_len;
    }
  }
?>

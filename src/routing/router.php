<?php
  class Router {
    private $url_params;
    private $url_params_len;

    public function __construct($url) {
      $this->url_params = $url === '' ? [''] : explode('/', rtrim($url, '/'));
      $this->url_params_len = count($this->url_params);
    }

    public function get_from_url() {
      switch($this->url_params[0]) {
        case '':
          $this->url_params_len > 1 ? $this->page_not_found() : $this->get('/home.php');
          break;
        case 'log_in':
          $this->url_params_len > 1 ? $this->page_not_found() : $this->get('/log_in.php');
          break;
        case 'register':
          $this->url_params_len > 1 ? $this->page_not_found() : $this->get('/register.php');
          break;
        default:
          $this->page_not_found();
      }
    }

    public function get($page_name) {
      require_once(SRC_DIR . $page_name);
      exit;
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

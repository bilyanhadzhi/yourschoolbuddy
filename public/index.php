<?php require_once('../config/config.php');?>

<?php
  function getPage($pageName) {
    require_once(SRC_DIR . $pageName);
  }
  function pageNotFound() {
    http_response_code(404);
    echo '404 Error: Page not found';
    exit;
  }

  if (isset($_GET['url'])) {
    $queryArr = explode('/', rtrim($_GET['url'], '/'));
    $queryArrLen = count($queryArr);

    switch ($queryArr[0]) {
      case 'login':
        $queryArrLen > 1 ? pageNotFound() : getPage('/login.php');
        break;
      case 'register':
        $queryArrLen > 1 ? pageNotFound() : getPage('/register.php');
        break;
      default:
        pageNotFound();
    }
  } else {
    getPage('/home.php');
  }
?>

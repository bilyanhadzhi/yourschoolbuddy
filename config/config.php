<?php
  $project_root_dir = '/app';
  $src_dir = $project_root_dir . '/src';
  $public_dir = $project_root_dir . '/public';

  $db_url = getenv('JAWSDB_URL');
  $dbparts = parse_url($db_url);

  $db_host = $dbparts['host'];
  $db_username = $dbparts['user'];
  $db_password = $dbparts['pass'];
  $database = ltrim($dbparts['path'], '/');

  $db_driver = 'mysql:host=' . $db_host . ';dbname=' . $database;

  $root_url = 'https://mysterious-plateau-59715.herokuapp.com';

  define('PROJECT_ROOT_DIR', $project_root_dir);
  define('SRC_DIR', $src_dir);
  define('PUBLIC_DIR', $public_dir);
  define('DB_DRIVER', $db_driver);
  define('DB_USERNAME', $db_username);
  define('DB_PASSWORD', $db_password);
  define('ROOT_URL', $root_url);
?>

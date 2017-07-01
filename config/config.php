<?php
  $project_root_dir = '/home/bilyan/Coding/projects/yourschoolbuddy';
  $src_dir = $project_root_dir . '/src';
  $public_dir = $project_root_dir . '/public';

  $db_host = 'localhost';
  $db_name = 'yourschoolbuddy';
  $db_driver = "mysql:host=$db_host;dbname=$db_name" ;

  $db_username = 'root';
  $db_password = 'root';

  $root_url = 'http://192.168.1.100:81';

  define('PROJECT_ROOT_DIR', $project_root_dir);
  define('SRC_DIR', $src_dir);
  define('PUBLIC_DIR', $public_dir);
  define('DB_DRIVER', $db_driver);
  define('DB_USERNAME', $db_username);
  define('DB_PASSWORD', $db_password);
  define('ROOT_URL', $root_url);
?>

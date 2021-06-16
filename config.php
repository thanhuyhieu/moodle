<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'pgsql';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle';
$CFG->dbuser    = 'postgres';
$CFG->dbpass    = 'postgres';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => 5432,
  'dbsocket' => '',
);

$CFG->wwwroot   = 'http://localhost/moodle';
$CFG->dataroot  = 'C:\\xampp\\moodledata';
$CFG->admin     = 'admin';


$CFG->phpunit_prefix = 'phpu_';
$CFG->phpunit_dataroot = 'C:\\xampp\\phpu_moodledata';
$CFG->phpunit_dbtype    = 'pgsql';      // 'pgsql', 'mariadb', 'mysqli', 'mssql', 'sqlsrv' or 'oci'
$CFG->phpunit_dblibrary = 'native';     // 'native' only at the moment
$CFG->phpunit_dbhost    = '127.0.0.1';  // eg 'localhost' or 'db.isp.com' or IP
$CFG->phpunit_dbname    = 'moodle';     // database name, eg moodle
$CFG->phpunit_dbuser    = 'postgres';   // your database username
$CFG->phpunit_dbpass    = 'postgres';   // your database password


$CFG->behat_prefix = 'behat_';
$CFG->dataroot  = 'C:\\xampp\\behat_moodledata';
$CFG->wwwroot   = 'http://127.0.0.1/moodle';


$CFG->directorypermissions = 0777;


require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!

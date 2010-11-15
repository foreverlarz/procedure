<?php

/*********************************************
 * LESSON OF THE DAY:
 *
 * When returning data from MySQL, PHP returns
 *   - nulls as nulls
 *   - integers as numeric strings
 *   - zeroes as numeric strings
 *   - strings as strings
 *   - empty strings as empty strings
 *
 * In other words, everything is cast into a
 * string except for null values.
 *********************************************/



// we will be printing text
header('Content-Type: text; charset=utf-8');



// print the data and data types for a row of data with specified id
function larz_gettype($x) {
    if (is_null($x))    return 'null';
    if (is_int($x))     return 'integer';
    if (is_numeric($x)) return 'numeric string';
    if (is_string($x))  return 'string';
    return 'unknown';
};
function larz_printtypes($x) {
    foreach ($x as $field => $value) {
        echo "'$field' => '$value' (".larz_gettype($value).")\n";
    };
};
function larz_printrow($id) {
    $sql = "SELECT * FROM `procedure` WHERE `id` = $id";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
    larz_printtypes($row);
};



// define $dbms_host, $dbms_user, $dbms_pass, $dbms_db
include 'inc_credentials.php';



// connect to the mysql database
$dbmscnx = @mysql_pconnect($dbms_host, $dbms_user, $dbms_pass);
mysql_select_db($dbms_db);
mysql_query("SET NAMES 'utf8'");



// create our table
$sql = <<<EOF
CREATE TABLE `procedure` (
  `id`              int(11)     AUTO_INCREMENT,
  `larz_int`        int(11)     ,
  `larz_varchar`    varchar(16) ,
  `larz_text`       text        ,
  `larz_date`       date        ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
EOF;
mysql_query($sql);



// insert example data and print what php returns
$sql = <<<EOF
INSERT INTO `procedure`
SET `larz_int`     = 10
  , `larz_varchar` = 'i like coffee.'
  , `larz_text`    = 'my name is larz.'
  , `larz_date`    = '2010-11-15'
EOF;
$result = mysql_query($sql);
larz_printrow(mysql_insert_id());



// insert example data and print what php returns
$sql = <<<EOF
INSERT INTO `procedure`
SET `larz_int`     = 10
  , `larz_varchar` = 20
  , `larz_text`    = 30
  , `larz_date`    = 40
EOF;
$result = mysql_query($sql);
larz_printrow(mysql_insert_id());



// insert example data and print what php returns
$sql = <<<EOF
INSERT INTO `procedure`
SET `larz_int`     = NULL
  , `larz_varchar` = NULL
  , `larz_text`    = NULL
  , `larz_date`    = NULL
EOF;
$result = mysql_query($sql);
larz_printrow(mysql_insert_id());



// insert example data and print what php returns
$sql = <<<EOF
INSERT INTO `procedure`
SET `larz_int`     = 0
  , `larz_varchar` = ''
  , `larz_text`    = ''
  , `larz_date`    = ''
EOF;
$result = mysql_query($sql);
larz_printrow(mysql_insert_id());



// clean up
$sql = "DROP TABLE `procedure`";
mysql_query($sql);

?>

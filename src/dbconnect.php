<?php
/* ドライバ呼び出しを使用して ODBC データベースに接続する */
$dsn = 'mysql:dbname=posse;host=db';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);



//以下は通常index.phpに書かれる。



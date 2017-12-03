<?php
require("../autoload.inc.php");

$user = Secretaire::createFromInfo("secretaire", "prénom", "1234 rue", "12345", "ville", "mail", "0123456789", date('Y-m-d H:i:s'))->insertIntoBD("toto");

echo $user;

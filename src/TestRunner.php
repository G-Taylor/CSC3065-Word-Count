<?php
require 'Test.php';

$t = new Test();

$t->test_wordcount_function();
$t->testGet_ValidInput_Wordcount();
$t->testGet_NoInput_Wordcount();

exit();
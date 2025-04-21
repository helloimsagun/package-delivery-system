<?php
require_once 'location_based_assignment.php';

set_time_limit(300);

$result = runAutoAssignment();

file_put_contents('auto_assign_log.txt', date('Y-m-d H:i:s') . ": " . $result . "\n", FILE_APPEND);

echo $result;
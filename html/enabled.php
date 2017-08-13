<?php

if (!defined('PDO::ATTR_DRIVER_NAME')) {
echo 'PDO is unavailable<br/>';
}
elseif (defined('PDO::ATTR_DRIVER_NAME')) {
echo 'PDO is available<br/>';
}

?>

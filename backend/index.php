<?php

/**
 * @file index.php
 *
 * @brief Backend
 */

echo '<pre>';

$last_line = exec('ls -lha', $std, $retval);

foreach ($std as $value) {
	echo $value . "\n";
}

// Printing additional info
echo '
</pre>
<hr />Last line of the output: ' . $last_line . '
<hr />Return value: ' . $retval;

?>
<?php

$session_test = isset($_SESSION) ? 'yes' : 'no';

session_start();

?>
<pre>
<?=$session_test?>

<?php
$session_test = isset($_SESSION) ? 'yes' : 'no';
print_r($_SESSION);
?>
<?=$session_test?>
</pre>
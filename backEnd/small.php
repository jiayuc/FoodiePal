<?php
exec("smallr.r", $output, $return);

// Return will return non-zero upon an error
if (!$return) {
    echo "PDF Created Successfully";
} else {
    echo "PDF not created";
}
?>
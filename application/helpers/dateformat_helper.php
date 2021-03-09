<?php
function dateFormat($date, $format = 'd-M-Y'){
    return date($format, strtotime($date));
}
?>
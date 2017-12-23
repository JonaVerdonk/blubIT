
<?php
    $p = $_POST;
    if (isset($p['to']) && isset($P['subject']) && isset($p['msg'])) {
        $header = "From: info@blubit.nl" . "\r\n";
        mail($p['to'], $p['subject'], $p['msg'], $header);
    }
?>

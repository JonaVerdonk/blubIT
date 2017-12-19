
<?php
    $p = $_POST;
    if (isset($p['to']) && isset($P['subject']) && isset($p['msg'])) {
        print mail($p['to'], $p['subject'], $p['msg']);
    }
?>

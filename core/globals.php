<?php

function dd($arg) {
    highlight_string("<?php\n" . var_export($arg, true) . "\n?>");
    echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
    exit;
}

function json($arg) {
    return json_encode($arg);
}
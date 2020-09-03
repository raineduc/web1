<?php
function renderTemplate($template, $vars) {
    ob_start();
    if (!empty($vars)) {
        extract($vars);
    }
    include($template);
}
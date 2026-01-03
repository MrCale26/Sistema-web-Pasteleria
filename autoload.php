<?php
function autoload($class_name) {
    if(file_exists('controllers/' . $class_name . '.php')) {
        require_once 'controllers/' . $class_name . '.php';
    } elseif(file_exists('models/' . $class_name . '.php')) {
        require_once 'models/' . $class_name . '.php';
    } elseif(file_exists('helpers/' . $class_name . '.php')) {
        require_once 'helpers/' . $class_name . '.php';
    }
}
spl_autoload_register('autoload');

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Custom PSR-4 Autoloader for Mike42 Escpos Library
 */
spl_autoload_register(function ($class) {
    // prefix for Mike42 namespace
    $prefix = 'Mike42\\';
    
    // base directory for the namespace prefix
    $base_dir = FCPATH . 'escpos-php-3.0/src/Mike42/';
    
    // does the class use the prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to next registered autoloader
        return;
    }
    
    // get the relative class name
    $relative_class = substr($class, $len);
    
    // replace namespace separators with directory separators in the relative class name, append with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // if the file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});

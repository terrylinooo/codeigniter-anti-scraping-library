<?php

function autoload($class)
{

    /* All of the classes have names like "ReCaptcha\Foo", so we need
     * to replace the backslashes with frontslashes if we want the
     * name to map directly to a location in the filesystem.
     */
	 
    $class = str_replace('\\', '/', $class);

    /* First, check under the current directory. It is important that
     * we look here first, so that we don't waste time searching for
     * test classes in the common case.
     */
    $path = dirname(__FILE__) . '/' . $class. '.php';
	
    if (is_readable($path)) 
	{
        require_once $path;
    }
}

spl_autoload_register('autoload');

/* An autoloader for ReCaptcha\Foo classes. This should be require()d
 * by the user before attempting to instantiate any of the ReCaptcha
 * classes.
 */
 
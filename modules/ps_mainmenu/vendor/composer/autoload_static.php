<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit947d1cbc70153bb65a77660e486c51d7
{
    public static $classMap = array (
        'Ps_MainMenu' => __DIR__ . '/../..' . '/ps_mainmenu.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit947d1cbc70153bb65a77660e486c51d7::$classMap;

        }, null, ClassLoader::class);
    }
}

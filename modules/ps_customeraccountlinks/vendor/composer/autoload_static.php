<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit977acf8ef0695ce9b694d9c3a4d65064
{
    public static $classMap = array (
        'Ps_Customeraccountlinks' => __DIR__ . '/../..' . '/ps_customeraccountlinks.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit977acf8ef0695ce9b694d9c3a4d65064::$classMap;

        }, null, ClassLoader::class);
    }
}

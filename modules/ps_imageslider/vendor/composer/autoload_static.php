<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit80b42cd798cc4f021ece709ed6d34395
{
    public static $classMap = array (
        'Ps_ImageSlider' => __DIR__ . '/../..' . '/ps_imageslider.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit80b42cd798cc4f021ece709ed6d34395::$classMap;

        }, null, ClassLoader::class);
    }
}

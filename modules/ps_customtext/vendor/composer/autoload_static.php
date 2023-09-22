<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit80d15b231a4a07092c17a5977ea1ecee
{
    public static $classMap = array (
        'CustomText' => __DIR__ . '/../..' . '/classes/CustomText.php',
        'MigrateData' => __DIR__ . '/../..' . '/classes/MigrateData.php',
        'Ps_Customtext' => __DIR__ . '/../..' . '/ps_customtext.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit80d15b231a4a07092c17a5977ea1ecee::$classMap;

        }, null, ClassLoader::class);
    }
}

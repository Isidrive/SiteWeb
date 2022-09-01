<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf73cc6cf0a96be2739c8036336b7501c
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf73cc6cf0a96be2739c8036336b7501c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf73cc6cf0a96be2739c8036336b7501c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf73cc6cf0a96be2739c8036336b7501c::$classMap;

        }, null, ClassLoader::class);
    }
}

<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc6fdcb62859241459327af95f70c4d65
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tests\\' => 6,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc6fdcb62859241459327af95f70c4d65::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc6fdcb62859241459327af95f70c4d65::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc6fdcb62859241459327af95f70c4d65::$classMap;

        }, null, ClassLoader::class);
    }
}

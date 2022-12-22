<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdc818e3d3adeaf5c94f2358fd4f47b7c
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdc818e3d3adeaf5c94f2358fd4f47b7c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdc818e3d3adeaf5c94f2358fd4f47b7c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdc818e3d3adeaf5c94f2358fd4f47b7c::$classMap;

        }, null, ClassLoader::class);
    }
}

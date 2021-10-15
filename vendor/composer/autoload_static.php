<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf4cb70b4fd3e426ea3b846bb147d72a4
{
    public static $prefixLengthsPsr4 = array (
        '<' => 
        array (
            '<YourNamespace>\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        '<YourNamespace>\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Camaloon' => __DIR__ . '/../..' . '/camaloon.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf4cb70b4fd3e426ea3b846bb147d72a4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf4cb70b4fd3e426ea3b846bb147d72a4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf4cb70b4fd3e426ea3b846bb147d72a4::$classMap;

        }, null, ClassLoader::class);
    }
}

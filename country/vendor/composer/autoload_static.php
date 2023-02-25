<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite112128858db7e913fe152731c4d6226
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '667aeda72477189d0494fecd327c3641' => __DIR__ . '/..' . '/symfony/var-dumper/Resources/functions/dump.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\VarDumper\\' => 28,
        ),
        'N' => 
        array (
            'NguyenAry\\VietnamAddressAPI\\' => 28,
        ),
        'C' => 
        array (
            'Cocur\\Slugify\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\VarDumper\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/var-dumper',
        ),
        'NguyenAry\\VietnamAddressAPI\\' => 
        array (
            0 => __DIR__ . '/..' . '/nguyenary/vietnam-address-api/src',
        ),
        'Cocur\\Slugify\\' => 
        array (
            0 => __DIR__ . '/..' . '/cocur/slugify/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PHPExcel' => 
            array (
                0 => __DIR__ . '/..' . '/phpoffice/phpexcel/Classes',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite112128858db7e913fe152731c4d6226::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite112128858db7e913fe152731c4d6226::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite112128858db7e913fe152731c4d6226::$prefixesPsr0;
            $loader->classMap = ComposerStaticInite112128858db7e913fe152731c4d6226::$classMap;

        }, null, ClassLoader::class);
    }
}
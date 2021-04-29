<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit86f4bb3065c5d6c794914b1fdd1dffc6
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Adwisemedia\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Adwisemedia\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Adwisemedia\\Exceptions\\UnlinkException' => __DIR__ . '/../..' . '/src/Exceptions/UnlinkException.php',
        'Adwisemedia\\Helpers\\Ajax' => __DIR__ . '/../..' . '/src/Helpers/Ajax.php',
        'Adwisemedia\\Helpers\\AttributeFactory' => __DIR__ . '/../..' . '/src/Helpers/AttributeFactory.php',
        'Adwisemedia\\Helpers\\ClassFactory' => __DIR__ . '/../..' . '/src/Helpers/ClassFactory.php',
        'Adwisemedia\\Helpers\\InlineStyleFactory' => __DIR__ . '/../..' . '/src/Helpers/InlineStyleFactory.php',
        'Adwisemedia\\Helpers\\ViewController' => __DIR__ . '/../..' . '/src/Helpers/ViewController.php',
        'Adwisemedia\\Plugins\\ACF\\Conditional' => __DIR__ . '/../..' . '/src/Plugins/ACF/Conditional.php',
        'Adwisemedia\\Plugins\\WooCommerce\\Conditional' => __DIR__ . '/../..' . '/src/Plugins/WooCommerce/Conditional.php',
        'Adwisemedia\\Utilities\\Arr' => __DIR__ . '/../..' . '/src/Utilities/Arr.php',
        'Adwisemedia\\Utilities\\Color' => __DIR__ . '/../..' . '/src/Utilities/Color.php',
        'Adwisemedia\\Utilities\\Dir' => __DIR__ . '/../..' . '/src/Utilities/Dir.php',
        'Adwisemedia\\Utilities\\General' => __DIR__ . '/../..' . '/src/Utilities/General.php',
        'Adwisemedia\\Utilities\\JSON' => __DIR__ . '/../..' . '/src/Utilities/JSON.php',
        'Adwisemedia\\Utilities\\Str' => __DIR__ . '/../..' . '/src/Utilities/Str.php',
        'Adwisemedia\\WordPress\\Transients' => __DIR__ . '/../..' . '/src/WordPress/Transients.php',
        'Adwisemedia\\WordPress\\Walkers\\DefaultNav' => __DIR__ . '/../..' . '/src/WordPress/Walkers/DefaultNav.php',
        'Adwisemedia\\WordPress\\Walkers\\SlideNav' => __DIR__ . '/../..' . '/src/WordPress/Walkers/SlideNav.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit86f4bb3065c5d6c794914b1fdd1dffc6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit86f4bb3065c5d6c794914b1fdd1dffc6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit86f4bb3065c5d6c794914b1fdd1dffc6::$classMap;

        }, null, ClassLoader::class);
    }
}

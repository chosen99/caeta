<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf844134c7cf86504fae3e9986bc04b56
{
    public static $files = array (
        '2cffec82183ee1cea088009cef9a6fc3' => __DIR__ . '/..' . '/ezyang/htmlpurifier/library/HTMLPurifier.composer.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'ZipStream\\' => 10,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
            'PhpOffice\\PhpSpreadsheet\\' => 25,
        ),
        'M' => 
        array (
            'MyCLabs\\Enum\\' => 13,
            'Matrix\\' => 7,
        ),
        'C' => 
        array (
            'Complex\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ZipStream\\' => 
        array (
            0 => __DIR__ . '/..' . '/maennchen/zipstream-php/src',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
            1 => __DIR__ . '/..' . '/psr/http-factory/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'PhpOffice\\PhpSpreadsheet\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpspreadsheet/src/PhpSpreadsheet',
        ),
        'MyCLabs\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/myclabs/php-enum/src',
        ),
        'Matrix\\' => 
        array (
            0 => __DIR__ . '/..' . '/markbaker/matrix/classes/src',
        ),
        'Complex\\' => 
        array (
            0 => __DIR__ . '/..' . '/markbaker/complex/classes/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'H' => 
        array (
            'HTMLPurifier' => 
            array (
                0 => __DIR__ . '/..' . '/ezyang/htmlpurifier/library',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Stringable' => __DIR__ . '/..' . '/myclabs/php-enum/stubs/Stringable.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf844134c7cf86504fae3e9986bc04b56::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf844134c7cf86504fae3e9986bc04b56::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitf844134c7cf86504fae3e9986bc04b56::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitf844134c7cf86504fae3e9986bc04b56::$classMap;

        }, null, ClassLoader::class);
    }
}

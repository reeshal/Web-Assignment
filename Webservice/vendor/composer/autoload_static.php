<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2b2afc7672e82821af7304797ded6269
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'Opis\\JsonSchema\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Opis\\JsonSchema\\' => 
        array (
            0 => __DIR__ . '/..' . '/opis/json-schema/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2b2afc7672e82821af7304797ded6269::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2b2afc7672e82821af7304797ded6269::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

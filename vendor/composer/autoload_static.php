<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd5117aa2341b54e048089651f5699662
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd5117aa2341b54e048089651f5699662::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd5117aa2341b54e048089651f5699662::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}

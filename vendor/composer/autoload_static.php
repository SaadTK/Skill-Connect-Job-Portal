<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit42bfed81f6001217e5fc366cc3c41f84
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
            'Saadt\\SkillConnectProject\\' => 26,
        ),
        'P' => 
        array (
            'Predis\\' => 7,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
        'Saadt\\SkillConnectProject\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Predis\\' => 
        array (
            0 => __DIR__ . '/..' . '/predis/predis/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit42bfed81f6001217e5fc366cc3c41f84::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit42bfed81f6001217e5fc366cc3c41f84::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit42bfed81f6001217e5fc366cc3c41f84::$classMap;

        }, null, ClassLoader::class);
    }
}
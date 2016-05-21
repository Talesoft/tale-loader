<?php

namespace Tale;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Tale\Loader\ComposerLoader;
use Tale\Loader\PsrLoader;
use Composer\Autoload\ClassLoader;

class Loader
{

    private function __construct() {}

    /**
     * @param ClassLoader $composerLoaderInstance
     *
     * @return LoaderInterface
     */
    public static function create($composerLoaderInstance = null)
    {

        if ($composerLoaderInstance && !is_a($composerLoaderInstance, 'Composer\\Autoload\\ClassLoader'))
            throw new InvalidArgumentException(
                "Argument 1 passed to Loader->create needs to be a valid Composer\\Autoload\\ClassLoader instance"
            );

        if ($composerLoaderInstance)
            return new ComposerLoader($composerLoaderInstance);

        return new PsrLoader();
    }
}
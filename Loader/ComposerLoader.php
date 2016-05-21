<?php

namespace Tale\Loader;

use Composer\Autoload\ClassLoader;
use Tale\AbstractLoader;

class ComposerLoader extends AbstractLoader
{
    
    private $innerLoader;

    public function __construct(ClassLoader $innerLoader)
    {
        parent::__construct();

        $this->innerLoader = $innerLoader;
    }

    public function addDefinition(DefinitionInterface $definition, $prepend = false)
    {

        $this->innerLoader->addPsr4($definition->getNameSpace(), $definition->getPath());

        return $this;
    }

    public function register($prepend = false)
    {

        $this->innerLoader->register($prepend);

        return parent::register($prepend);
    }

    public function unregister()
    {

        $this->innerLoader->unregister();

        return parent::unregister();
    }

    public function loadClass($className)
    {

        return $this->innerLoader->loadClass($className);
    }
}
<?php

namespace Tale;

use Tale\Loader\DefinitionInterface;

interface LoaderInterface
{

    public function addDefinition(DefinitionInterface $definition, $prepend = false);
    public function add($nameSpace, $path, $prepend = false);

    public function isRegistered();
    public function register($prepend = false);
    public function unregister();
    
    public function loadClass($className);
}
<?php

namespace Tale\Loader;

class Definition implements DefinitionInterface
{

    private $nameSpace;
    private $path;

    public function __construct($nameSpace, $path)
    {

        $this->nameSpace = $nameSpace;
        $this->path = $path;
    }

    public function getNameSpace()
    {

        return $this->nameSpace;
    }

    public function getPath()
    {

        return $this->path;
    }
}
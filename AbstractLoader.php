<?php

namespace Tale;

use Tale\Loader\Definition;

abstract class AbstractLoader implements LoaderInterface
{

    /**
     * The flag that tells if the loader is registered or not.
     *
     * @var bool
     */
    private $registered;

    public function __construct()
    {

        $this->registered = false;
    }

    /**
     * Unregisters the auto-loader automatically on object destruction.
     */
    public function __destruct()
    {

        $this->unregister();
    }

    /**
     * Checks if the loader is registered or not
     *
     * @return bool
     */
    public function isRegistered()
    {

        return $this->registered;
    }

    public function register($prepend = false)
    {

        $this->registered = true;

        return $this;
    }

    public function unregister()
    {

        $this->registered = false;

        return $this;
    }

    public function add($nameSpace, $path, $prepend = false)
    {

        return $this->addDefinition(new Definition($nameSpace, $path), $prepend);
    }
}
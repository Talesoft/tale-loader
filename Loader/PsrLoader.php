<?php

namespace Tale\Loader;

use Tale\AbstractLoader;

/**
 * A class loader with zero dependencies (and zero configuration, if you like)
 *
 * You might just include the file containing this class and get a class-loader up and running easily
 *
 *
 * @package Tale
 */
class PsrLoader extends AbstractLoader
{

    /** @var DefinitionInterface[] */
    private $definitions;
    
    /**
     * The handle given to spl_autoload_register.
     *
     * @var callable
     */
    private $handle;

    /**
     * Creates a new auto-loader.
     *
     * Call $this->register() to register the loader after instanciation
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->definitions = [];
        $this->handle = [$this, 'loadClass'];
    }

    public function addDefinition(DefinitionInterface $definition, $prepend = false)
    {

        if ($prepend)
            array_unshift($this->definitions, $definition);
        else
            $this->definitions[] = $definition;

        return $this;
    }

    /**
     * Registers the class loader (activates it).
     *
     * Basically, spl_autoload_register($this->getHandle())
     *
     * @param bool $prepend
     *
     * @return $this
     */
    public function register($prepend = false)
    {

        if ($this->isRegistered())
            return $this;

        try {
            
            spl_autoload_register($this->handle, true, $prepend);
        } catch(\Exception $e) {

            throw new \RuntimeException(
                "Failed to register ".static::class." as a SPL autoloader (spl_autoload_register())", 0, $e
            );
        }

        return parent::register($prepend);
    }

    /**
     * Unregisters the class loader (deactivates it).
     *
     * Basically, spl_autoload_unregister($this->getHandle())
     *
     * @return $this
     */
    public function unregister()
    {

        if (!$this->isRegistered())
            return $this;

        if (spl_autoload_unregister($this->handle))
            return parent::unregister();

        return $this;
    }

    /**
     * Loads a class based on its class name.
     *
     * If it's not found, it's simply ignored in order to let another loader try to load it
     * If it's the only loader, an error will be thrown after a failed loading
     *
     * There's no loader recursion, the final check uses the second parameter of class_exists() to
     * not trigger another autoloader inside this one
     *
     * @param string $className The FQCN of the class to load
     *
     * @return bool Has the class been loaded or not
     */
    public function loadClass($className)
    {

        foreach ($this->definitions as $def) {

            $nameSpace = $def->getNameSpace();
            $path = $def->getPath();
            $name = $className;
            if ($nameSpace) {

                $ns = rtrim($nameSpace, '\\').'\\';

                $nameLen = strlen($className);
                $nsLen = strlen($ns);

                if ($nameLen < $nsLen || substr($className, 0, $nsLen) !== $ns)
                    return false;

                $name = substr($name, $nsLen);
            }

            $ds = DIRECTORY_SEPARATOR;
            $path = $path ? $path.$ds : '';
            $path .= str_replace(['_', '\\'], $ds, $name).'.php';

            if (($path = stream_resolve_include_path($path)) !== false)
                include $path;

            if (class_exists($className, false))
                return true;
        }

        return false;
    }
}
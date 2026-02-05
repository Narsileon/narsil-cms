<?php

namespace Narsil\Cms\Console\Commands;

#region USE

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Narsil\Cms\Models\Collections\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class MakeModelCommand extends GeneratorCommand
{
    #region PROPERTIES

    /**
     * @param Template $template
     */
    protected Template $template;

    /**
     * {@inheritDoc}
     */
    protected $type = 'Model';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(): bool|null
    {
        $this->template = Template::find($this->argument('template'));

        return parent::handle();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function buildClass($name): string
    {
        $replacements = [
            '{{ table }}' => $this->getTable($name),
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            parent::buildClass($name)
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function getNamespace($name): string
    {
        return $this->template->entityNamespace();
    }

    /**
     * {@inheritDoc}
     */
    protected function getPath($name): string
    {
        $namespace = $this->getNamespace($name);

        $path = Str::lcfirst(Str::replace('\\', '/', $namespace));

        $directory = base_path($path);

        $class = $this->getClass($name);

        return $directory . '/' . $class . '.php';
    }

    /**
     * {@inheritDoc}
     */
    protected function replaceClass($stub, $name): string
    {
        $class = $this->getClass($name);

        return str_replace('{{ class }}', $class, $stub);
    }

    /**
     * {@inheritDoc}
     */
    protected function replaceNamespace(&$stub, $name): self
    {
        $namespace = $this->getNamespace($name);

        $stub = str_replace('{{ namespace }}', $namespace, $stub);

        return $this;
    }

    #endregion
}

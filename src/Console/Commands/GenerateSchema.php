<?php

namespace Narsil\Console\Commands;

#region USE

use Illuminate\Console\Command;
use Narsil\Services\GraphQLService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class GenerateSchema extends Command
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->signature = 'narsil:generate-schema';
        $this->description = 'Generate a GraphQL schema based on templates.';

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('Generating GraphQL schema...');

        GraphQLService::generateTemplatesSchema();

        $this->info('GraphQL schema has been generated successfully.');
    }

    #endregion
}

<?php

declare(strict_types=1);

namespace Narsil\Cms\Models;

#region USE

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Observers\ModelObserver;
use Narsil\Cms\Policies\RedirectPolicy;

#endregion

#[ObservedBy(ModelObserver::class)]
#[UsePolicy(RedirectPolicy::class)]
class Redirect extends Model
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = [
            self::ID,
        ];

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'redirects';

    #region • COLUMNS

    /**
     * The name of the "url destination" column.
     *
     * @var string
     */
    final public const URL_DESTINATION = 'url_destination';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "url source" column.
     *
     * @var string
     */
    final public const URL_SOURCE = 'url_source';

    /**
     * The name of the "status code" column.
     *
     * @var string
     */
    final public const STATUS_CODE = 'status_code';

    #endregion

    #endregion
}

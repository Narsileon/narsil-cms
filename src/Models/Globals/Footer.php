<?php

namespace Narsil\Models\Globals;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Footer extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->mergeGuarded([
            self::ID,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'footers';

    #region • COLUMNS

    /**
     * The name of the "address line 1" column.
     *
     * @var string
     */
    final public const ADDRESS_LINE_1 = 'address_line_1';

    /**
     * The name of the "address line 2" column.
     *
     * @var string
     */
    final public const ADDRESS_LINE_2 = 'address_line_2';

    /**
     * The name of the "company" column.
     *
     * @var string
     */
    final public const COMPANY = 'company';

    /**
     * The name of the "email" column.
     *
     * @var string
     */
    final public const EMAIl = 'email';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "logo" column.
     *
     * @var string
     */
    final public const LOGO = 'logo';

    /**
     * The name of the "phone" column.
     *
     * @var string
     */
    final public const PHONE = 'phone';

    #endregion

    #endregion
}

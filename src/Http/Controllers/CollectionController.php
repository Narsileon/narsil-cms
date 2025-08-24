<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Inertia\Response;
use Narsil\Contracts\FormRequests\EntityFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class CollectionController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @param EntityFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(EntityFormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var EntityFormRequest
     */
    protected readonly EntityFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $collection
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Entity::class);

        $tables = Template::pluck(Template::HANDLE)->unique()->toArray();

        $caseSql = "CASE";

        foreach ($tables as $table)
        {
            if (Schema::hasTable($table))
            {
                $caseSql .= " WHEN handle = '{$table}' THEN (SELECT COUNT(*) FROM {$table} WHERE deleted_at IS NULL)";
            }
        }

        $caseSql .= " ELSE 0 END as entities_count";

        $query = Template::query()
            ->select(Template::TABLE . '.*')
            ->selectRaw($caseSql);

        $dataTable = new DataTableCollection($query, 'collections')
            ->setSelectable(false);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::ui.collections'),
            description: trans('narsil::ui.collections'),
            props: [
                'dataTable' => $dataTable,
            ]
        );
    }

    #endregion
}

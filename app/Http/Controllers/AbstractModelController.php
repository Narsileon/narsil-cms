<?php

namespace App\Http\Controllers;

#region USE

use App\Constants\TanStackTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractModelController
{
    #region PROTECTED METHODS

    protected function filter(Builder $query, string $column, mixed $filter = null): void
    {
        if (!$filter)
        {
            $filter = request(TanStackTable::FILTER, null);
        }

        if (!$filter)
        {
            return;
        }

        $query->where($column, '=', $filter);
    }

    /**
     * @param array $rules
     *
     * @return array
     */
    protected function getAttributes(array $rules): array
    {
        $data = request()->all();

        $validator = Validator::make($data, $rules);

        return $validator->validated();
    }

    /**
     * @param string $table
     *
     * @return RedirectResponse
     */
    protected function redirectOnDestroyed(string $table): RedirectResponse
    {
        $toast = trans("toasts.success.$table.deleted");

        if (request()->get('_back'))
        {
            return back()->with('success', $toast);
        }
        else
        {
            return redirect(route(Str::slug($table) .  '.index'))
                ->with('success', $toast);
        }
    }

    /**
     * @param string $table
     *
     * @return RedirectResponse
     */
    protected function redirectOnStored(string $table): RedirectResponse
    {
        $toast = trans("toasts.success.$table.created");

        if (request()->get('_back'))
        {
            return back()->with('success', $toast);
        }
        else
        {
            return redirect(route(Str::slug($table) .  '.index'))
                ->with('success', $toast);
        }
    }

    /**
     * @param string $table
     *
     * @return RedirectResponse
     */
    protected function redirectOnUpdated(string $table): RedirectResponse
    {
        $toast = trans("toasts.success.$table.updated");

        if (request()->get('_back'))
        {
            return back()->with('success', $toast);
        }
        else
        {
            return redirect(route(Str::slug($table) .  '.index'))
                ->with('success', $toast);
        }
    }

    #endregion
}

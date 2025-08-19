import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Link } from "@inertiajs/react";
import { ModalLink } from "@narsil-cms/components/ui/modal";
import { route } from "ziggy-js";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/ui/dropdown-menu";
import type { RouteNames } from "@narsil-cms/types/collection";
import type { Table } from "@tanstack/react-table";

type DataTableRowMenuProps = Omit<
  React.ComponentProps<typeof DropdownMenuTrigger>,
  "id"
> & {
  id?: number;
  modal?: boolean;
  routes: RouteNames;
  table?: Table<any>;
};

function DataTableRowMenu({
  id,
  modal = false,
  routes,
  table,
  ...props
}: DataTableRowMenuProps) {
  const { trans } = useLabels();

  if (!routes.edit && !routes.destroy) {
    return null;
  }

  return (
    <DropdownMenu>
      <Tooltip tooltip={trans("accessibility.toggle_row_menu")}>
        <DropdownMenuTrigger asChild={true} {...props}>
          <Button
            className="hover:bg-secondary size-7"
            size="icon"
            variant="ghost"
          >
            <Icon name="more-horizontal" />
          </Button>
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent align="end">
        {id ? (
          <>
            {routes.edit ? (
              <DropdownMenuItem asChild={true}>
                {modal ? (
                  <ModalLink
                    href={route(routes.edit, {
                      ...routes.params,
                      id: id,
                    })}
                  >
                    <Icon name="edit" />
                    {trans("ui.edit")}
                  </ModalLink>
                ) : (
                  <Link
                    as="button"
                    href={route(routes.edit, {
                      ...routes.params,
                      id: id,
                    })}
                  >
                    <Icon name="edit" />
                    {trans("ui.edit")}
                  </Link>
                )}
              </DropdownMenuItem>
            ) : null}
            <DropdownMenuSeparator />
            {routes.destroy ? (
              <DropdownMenuItem asChild={true}>
                <Link
                  as="button"
                  href={route(routes.destroy, {
                    ...routes.params,
                    id: id,
                  })}
                  method="delete"
                  data={{
                    _back: true,
                  }}
                >
                  <Icon name="trash" />
                  {trans("ui.delete")}
                </Link>
              </DropdownMenuItem>
            ) : null}
          </>
        ) : (
          <>
            <DropdownMenuItem
              onClick={() => {
                table?.resetRowSelection();
              }}
            >
              <Icon name="x" />
              {trans("ui.deselect_all")}
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            {routes.destroyMany ? (
              <DropdownMenuItem asChild={true}>
                <Link
                  as="button"
                  href={route(routes.destroyMany, {
                    ...routes.params,
                    ids: table
                      ?.getSelectedRowModel()
                      .flatRows.map((row) => row.original.id),
                  })}
                  method="delete"
                  data={{
                    _back: true,
                  }}
                >
                  <Icon name="trash" />
                  {trans("ui.delete_selected")}
                </Link>
              </DropdownMenuItem>
            ) : null}
          </>
        )}
        {}
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default DataTableRowMenu;

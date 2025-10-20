import { Link } from "@inertiajs/react";
import { Button, Tooltip } from "@narsil-cms/blocks";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { ModalLink } from "@narsil-cms/components/modal";
import type { Model, RouteNames } from "@narsil-cms/types";
import { type Table } from "@tanstack/react-table";
import { type ComponentProps } from "react";
import { route } from "ziggy-js";

type DataTableRowMenuProps = Omit<ComponentProps<typeof DropdownMenuTrigger>, "id"> & {
  id?: number;
  modal?: boolean;
  routes: RouteNames;
  table?: Table<Model>;
};

function DataTableRowMenu({ id, modal = false, routes, table, ...props }: DataTableRowMenuProps) {
  const { trans } = useLocalization();

  if (!routes.edit && !routes.destroy) {
    return null;
  }

  return (
    <DropdownMenuRoot>
      <Tooltip tooltip={trans("accessibility.toggle_row_menu")}>
        <DropdownMenuTrigger asChild={true} {...props}>
          <div className="flex items-center justify-end">
            <Button
              className="hover:bg-secondary size-7"
              aria-label={trans("accessibility.toggle_row_menu")}
              icon="more-horizontal"
              size="icon"
              variant="ghost"
              onClick={(event) => event.stopPropagation()}
            />
          </div>
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent align="end" onClick={(event) => event.stopPropagation()}>
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
            {routes.replicate ? (
              <DropdownMenuItem asChild={true}>
                <Link
                  as="button"
                  href={route(routes.replicate, {
                    ...routes.params,
                    id: id,
                  })}
                  method="post"
                >
                  <Icon name="copy" />
                  {trans("ui.duplicate")}
                </Link>
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
            {routes.replicateMany ? (
              <DropdownMenuItem asChild={true}>
                <Link
                  as="button"
                  href={route(routes.replicateMany, {
                    ...routes.params,
                    ids: table?.getSelectedRowModel().flatRows.map((row) => row.original.id),
                  })}
                  method="post"
                  data={{
                    _back: true,
                  }}
                >
                  <Icon name="trash" />
                  {trans("ui.duplicate_selected")}
                </Link>
              </DropdownMenuItem>
            ) : null}

            {routes.destroyMany ? (
              <>
                <DropdownMenuSeparator />
                <DropdownMenuItem asChild={true}>
                  <Link
                    as="button"
                    href={route(routes.destroyMany, {
                      ...routes.params,
                      ids: table?.getSelectedRowModel().flatRows.map((row) => row.original.id),
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
              </>
            ) : null}
          </>
        )}
      </DropdownMenuContent>
    </DropdownMenuRoot>
  );
}

export default DataTableRowMenu;

import { Link, router } from "@inertiajs/react";
import { Icon } from "@narsil-cms/blocks/icon";
import { useAlertDialog } from "@narsil-cms/components/alert-dialog";
import { Button } from "@narsil-cms/components/button";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useLocalization } from "@narsil-cms/components/localization";
import { ModalLink } from "@narsil-cms/components/modal";
import { Tooltip } from "@narsil-cms/components/tooltip";
import type { Model, RouteNames } from "@narsil-cms/types";
import { type Table } from "@tanstack/react-table";
import { type ComponentProps } from "react";
import { route } from "ziggy-js";

type DataTableRowMenuProps = Omit<ComponentProps<typeof DropdownMenuTrigger>, "id"> & {
  id?: number | string;
  modal?: boolean;
  routes: RouteNames;
  table?: Table<Model>;
};

function DataTableRowMenu({ id, modal = false, routes, table, ...props }: DataTableRowMenuProps) {
  const { setAlertDialog } = useAlertDialog();
  const { trans } = useLocalization();

  if (!routes.edit && !routes.destroy) {
    return null;
  }

  return (
    <DropdownMenuRoot>
      <Tooltip tooltip={trans("accessibility.toggle_row_menu")}>
        <DropdownMenuTrigger
          {...props}
          render={
            <Button
              aria-label={trans("accessibility.toggle_row_menu")}
              size="icon-sm"
              variant="ghost-secondary"
              onClick={(event) => event.stopPropagation()}
            >
              <Icon name="more-horizontal" />
            </Button>
          }
        />
      </Tooltip>
      <DropdownMenuPortal>
        <DropdownMenuPositioner align="end">
          <DropdownMenuPopup onClick={(event) => event.stopPropagation()}>
            {id ? (
              <>
                {routes.edit ? (
                  <DropdownMenuItem
                    render={
                      modal ? (
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
                      )
                    }
                  />
                ) : null}
                {routes.replicate ? (
                  <DropdownMenuItem
                    render={
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
                    }
                  />
                ) : null}
                <DropdownMenuSeparator />
                {routes.destroy ? (
                  <DropdownMenuItem
                    onClick={() => {
                      const href = route(routes.destroy as string, {
                        ...routes.params,
                        id: id,
                      });

                      setAlertDialog({
                        title: trans("dialogs.titles.delete"),
                        description: trans("dialogs.descriptions.delete"),
                        buttons: [
                          {
                            onClick: () => {
                              router.delete(href, {
                                data: {
                                  _back: true,
                                },
                              });
                            },
                          },
                        ],
                      });
                    }}
                  >
                    <Icon name="trash" />
                    {trans("ui.delete")}
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
                  <DropdownMenuItem
                    render={
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
                    }
                  />
                ) : null}

                {routes.destroyMany ? (
                  <>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem
                      onClick={() => {
                        const href = route(routes.destroyMany as string, {
                          ...routes.params,
                          ids: table?.getSelectedRowModel().flatRows.map((row) => row.original.id),
                        });

                        setAlertDialog({
                          title: trans("dialogs.titles.delete"),
                          description: trans("dialogs.descriptions.delete"),
                          buttons: [
                            {
                              onClick: () => {
                                router.delete(href, {
                                  data: {
                                    _back: true,
                                  },
                                });
                              },
                            },
                          ],
                        });
                      }}
                    >
                      <Icon name="trash" />
                      {trans("ui.delete_selected")}
                    </DropdownMenuItem>
                  </>
                ) : null}
              </>
            )}
          </DropdownMenuPopup>
        </DropdownMenuPositioner>
      </DropdownMenuPortal>
    </DropdownMenuRoot>
  );
}

export default DataTableRowMenu;

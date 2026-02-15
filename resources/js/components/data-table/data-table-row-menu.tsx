import { Link, router } from "@inertiajs/react";
import { ModalLink } from "@narsil-cms/components/modal";
import { useAlertDialog } from "@narsil-ui/components/alert-dialog";
import { Button } from "@narsil-ui/components/button";
import { Data } from "@narsil-ui/components/data-table";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-ui/components/dropdown-menu";
import { Icon } from "@narsil-ui/components/icon";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { RoutesData } from "@narsil-ui/types";
import { type Table } from "@tanstack/react-table";
import { type ComponentProps } from "react";
import { route } from "ziggy-js";

type DataTableRowMenuProps = Omit<ComponentProps<typeof DropdownMenuTrigger>, "id"> & {
  id?: number | string;
  modal?: boolean;
  routes: RoutesData;
  table?: Table<Data>;
};

function DataTableRowMenu({ id, modal = false, routes, table, ...props }: DataTableRowMenuProps) {
  const { setAlertDialog } = useAlertDialog();
  const { trans } = useTranslator();

  if (!routes.edit && !routes.destroy) {
    return null;
  }

  return (
    <DropdownMenuRoot>
      <Tooltip tooltip={trans("tooltips.menu")}>
        <DropdownMenuTrigger
          {...props}
          render={
            <Button
              aria-label={trans("tooltips.menu")}
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
                            ...routes.parameters,
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
                            ...routes.parameters,
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
                          ...routes.parameters,
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
                        ...routes.parameters,
                        id: id,
                      });

                      setAlertDialog({
                        title: trans("dialogs.titles.delete"),
                        description: trans("dialogs.descriptions.delete"),
                        actions: [
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
                  {trans("data-table.deselect_all")}
                </DropdownMenuItem>
                {routes.replicateMany ? (
                  <DropdownMenuItem
                    render={
                      <Link
                        as="button"
                        href={route(routes.replicateMany, {
                          ...routes.parameters,
                          ids: table?.getSelectedRowModel().flatRows.map((row) => row.original.id),
                        })}
                        method="post"
                        data={{
                          _back: true,
                        }}
                      >
                        <Icon name="trash" />
                        {trans("data-table.duplicate_selected")}
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
                          ...routes.parameters,
                          ids: table?.getSelectedRowModel().flatRows.map((row) => row.original.id),
                        });

                        setAlertDialog({
                          title: trans("dialogs.titles.delete"),
                          description: trans("dialogs.descriptions.delete"),
                          actions: [
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
                      {trans("data-table.delete_selected")}
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

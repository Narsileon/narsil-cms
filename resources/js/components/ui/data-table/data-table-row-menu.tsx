import { Button } from "@narsil-cms/components/ui/button";
import { DeleteIcon, EditIcon, MoreHorizontalIcon } from "lucide-react";
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

type DataTableRowMenuProps = Omit<
  React.ComponentProps<typeof DropdownMenuTrigger>,
  "id"
> & {
  id: number;
  modal?: boolean;
  routes: RouteNames;
};

function DataTableRowMenu({
  id,
  modal = false,
  routes,
  ...props
}: DataTableRowMenuProps) {
  const { getLabel } = useLabels();

  if (!routes.edit && !routes.destroy) {
    return null;
  }

  return (
    <DropdownMenu>
      <Tooltip tooltip={getLabel("accessibility.toggle_row_menu")}>
        <DropdownMenuTrigger asChild={true} {...props}>
          <Button
            className="hover:bg-secondary size-7"
            size="icon"
            variant="ghost"
          >
            <MoreHorizontalIcon className="size-5" />
          </Button>
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent align="end">
        {routes.edit ? (
          <DropdownMenuItem asChild={true}>
            {modal ? (
              <ModalLink href={route(routes.edit, id)}>
                <EditIcon />
                {getLabel("ui.edit")}
              </ModalLink>
            ) : (
              <Link as="button" href={route(routes.edit, id)}>
                <EditIcon />
                {getLabel("ui.edit")}
              </Link>
            )}
          </DropdownMenuItem>
        ) : null}
        <DropdownMenuSeparator />
        {routes.destroy ? (
          <DropdownMenuItem asChild={true}>
            <Link
              as="button"
              href={route(routes.destroy, id)}
              method="delete"
              data={{
                _back: true,
              }}
            >
              <DeleteIcon />
              {getLabel("ui.delete")}
            </Link>
          </DropdownMenuItem>
        ) : null}
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default DataTableRowMenu;

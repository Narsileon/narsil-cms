import { Button } from "@/components/ui/button";
import { DeleteIcon, EditIcon, MoreHorizontalIcon } from "lucide-react";
import { Link } from "@inertiajs/react";
import { ModalLink } from "@/components/ui/modal";
import { route } from "ziggy-js";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import type { RouteNames } from "@/types";

type DataTableRowMenuProps = Omit<
  React.ComponentProps<typeof DropdownMenuTrigger>,
  "id"
> & {
  id: number;
  routes: RouteNames;
};

function DataTableRowMenu({ id, routes, ...props }: DataTableRowMenuProps) {
  const { getLabel } = useLabels();

  if (!routes.edit && !routes.destroy) {
    return null;
  }

  return (
    <DropdownMenu>
      <Tooltip tooltip={getLabel("accessibility.toggle_row_menu")}>
        <DropdownMenuTrigger asChild={true} {...props}>
          <Button className="size-8" size="icon" variant="ghost">
            <MoreHorizontalIcon className="size-5" />
          </Button>
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent align="end">
        {routes.edit ? (
          <DropdownMenuItem asChild={true}>
            <ModalLink href={route(routes.edit, id)}>
              <EditIcon />
              {getLabel("ui.edit")}
            </ModalLink>
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

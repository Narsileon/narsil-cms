import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { DeleteIcon, EditIcon, MoreHorizontalIcon } from "lucide-react";
import { Link } from "@inertiajs/react";
import { ModalLink } from "@/components/ui/modal";
import { route } from "ziggy-js";
import { useDataTable } from "@/components/ui/data-table";
import { useLabels } from "@/components/ui/labels";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import type { CategoriesCollection } from "@/types";

type DataTableFilterProps = React.ComponentProps<"ul"> &
  CategoriesCollection & {};

function DataTableFilter({
  className,
  data,
  meta,
  ...props
}: DataTableFilterProps) {
  const { getLabel } = useLabels();
  const { dataTableStore } = useDataTable();

  return (
    <ul className={cn("grid gap-2", className)} {...props}>
      <li>
        <Button
          className="w-full justify-start"
          variant="ghost"
          onClick={() => {
            dataTableStore.setFilter(null);
          }}
        >
          {"All"}
        </Button>
      </li>
      {data.map((category) => (
        <li
          className="flex items-center justify-between gap-2"
          key={category.id}
        >
          <Button className="grow justify-start" variant="ghost">
            {category.label}
          </Button>
          <DropdownMenu>
            <DropdownMenuTrigger asChild>
              <Button
                size="icon"
                variant="ghost"
                onClick={() => {
                  dataTableStore.setFilter(category.id.toString());
                }}
              >
                <MoreHorizontalIcon className="h-4 w-4" />
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
              {meta.routes.edit ? (
                <DropdownMenuItem asChild={true}>
                  <ModalLink href={route(meta.routes.edit, category.id)}>
                    <EditIcon />
                    {getLabel("ui.edit")}
                  </ModalLink>
                </DropdownMenuItem>
              ) : null}
              <DropdownMenuSeparator />
              {meta.routes.destroy ? (
                <DropdownMenuItem asChild={true}>
                  <Link
                    as="button"
                    href={route(meta.routes.destroy, category.id)}
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
        </li>
      ))}
      {meta.routes.create ? (
        <li>
          <Button asChild={true} className="w-full">
            <ModalLink href={route(meta.routes.create)}>
              {meta.create}
            </ModalLink>
          </Button>
        </li>
      ) : null}
    </ul>
  );
}

export default DataTableFilter;

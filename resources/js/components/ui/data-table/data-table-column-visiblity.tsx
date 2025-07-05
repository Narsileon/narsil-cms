import { Button } from "@/components/ui/button";
import { isString } from "lodash";
import { SettingsIcon } from "lucide-react";
import useDataTable from "./data-table-context";
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import type { ButtonProps } from "@/components/ui/button";

export type DataTableColumnVisibilityProps = ButtonProps & {};

function DataTableColumnVisibility({
  ...props
}: DataTableColumnVisibilityProps) {
  const { dataTable } = useDataTable();

  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild={true}>
        <Button size="icon" variant="outline" {...props}>
          <SettingsIcon />
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end">
        {dataTable
          .getAllColumns()
          .filter((column) => column.getCanHide())
          .map((column) => {
            if (!isString(column.columnDef.header)) {
              return null;
            }

            return (
              <DropdownMenuCheckboxItem
                key={column.id}
                checked={column.getIsVisible()}
                onCheckedChange={(value) => column.toggleVisibility(!!value)}
              >
                {column.columnDef.header}
              </DropdownMenuCheckboxItem>
            );
          })}
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default DataTableColumnVisibility;

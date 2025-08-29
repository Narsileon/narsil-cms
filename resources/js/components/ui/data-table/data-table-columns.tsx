import * as React from "react";
import { isString } from "lodash";
import useDataTable from "./data-table-context";
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from "@narsil-cms/components/ui/dropdown-menu";

type DataTableColumnsProps = React.ComponentProps<
  typeof DropdownMenuTrigger
> & {
  options?: string[];
};

function DataTableColumns({ children, ...props }: DataTableColumnsProps) {
  const { dataTable } = useDataTable();

  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild={true} {...props}>
        {children}
      </DropdownMenuTrigger>
      <DropdownMenuContent>
        {dataTable
          .getAllColumns()
          .filter((column) => column.getCanHide())
          .map((column) => {
            if (!isString(column.columnDef.header)) {
              return null;
            }

            return (
              <DropdownMenuCheckboxItem
                checked={column.getIsVisible()}
                onCheckedChange={(value) => column.toggleVisibility(!!value)}
                onSelect={(event) => event.preventDefault()}
                key={column.id}
              >
                {column.columnDef.header}
              </DropdownMenuCheckboxItem>
            );
          })}
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default DataTableColumns;

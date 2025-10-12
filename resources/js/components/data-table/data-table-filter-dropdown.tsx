import {
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuRoot,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { isString } from "lodash";
import { type ComponentProps } from "react";
import useDataTable from "./data-table-context";

type DataTableFilterDropdownProps = ComponentProps<typeof DropdownMenuTrigger> & {
  options?: string[];
};

function DataTableFilterDropdown({ children, ...props }: DataTableFilterDropdownProps) {
  const { dataTable, dataTableStore } = useDataTable();

  const filteredColumns = dataTableStore.filters.map((filter) => filter.column);

  return (
    <DropdownMenuRoot>
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
                checked={filteredColumns.includes(column.id)}
                onCheckedChange={(checked) => {
                  if (checked) {
                    dataTableStore.addFilter(column.id);
                  } else {
                    dataTableStore.removeFilter(column.id);
                  }
                }}
                key={column.id}
              >
                {column.columnDef.header}
              </DropdownMenuCheckboxItem>
            );
          })}
      </DropdownMenuContent>
    </DropdownMenuRoot>
  );
}

export default DataTableFilterDropdown;

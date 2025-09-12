import { isString } from "lodash";

import {
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuRoot,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";

import useDataTable from "./data-table-context";

type DataTableVisibilityDropdownProps = React.ComponentProps<
  typeof DropdownMenuTrigger
> & {
  options?: string[];
};

function DataTableVisibilityDropdown({
  children,
  ...props
}: DataTableVisibilityDropdownProps) {
  const { dataTable } = useDataTable();

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
    </DropdownMenuRoot>
  );
}

export default DataTableVisibilityDropdown;

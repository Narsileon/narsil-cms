import { ColumnDef } from "@tanstack/react-table";

import { DataTableRowMenu } from "@narsil-cms/components/data-table";
import type { BaseModel, RouteNames } from "@narsil-cms/types";

function getMenuColumn(routes: RouteNames): ColumnDef<BaseModel> {
  return {
    id: "_menu",
    header: ({ table }) => {
      const checked = table.getIsAllPageRowsSelected();
      const indeterminate = table.getIsSomePageRowsSelected();

      return checked || indeterminate ? (
        <DataTableRowMenu
          className="absolute right-1 top-1/2 -translate-y-1/2 transform"
          routes={routes}
          table={table}
        />
      ) : null;
    },
    cell: ({ row }) => {
      return (
        <DataTableRowMenu
          className="absolute right-1 top-1/2 -translate-y-1/2 transform"
          id={row.original.id}
          routes={routes}
        />
      );
    },
    enableHiding: false,
    enableSorting: false,
  };
}

export default getMenuColumn;

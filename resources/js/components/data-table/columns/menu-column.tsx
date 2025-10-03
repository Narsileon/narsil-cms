import { ColumnDef } from "@tanstack/react-table";

import { DataTableRowMenu } from "@narsil-cms/components/data-table";
import type { Model, RouteNames } from "@narsil-cms/types";

function getMenuColumn(routes: RouteNames): ColumnDef<Model> {
  return {
    id: "_menu",
    header: ({ table }) => {
      const checked = table.getIsAllPageRowsSelected();
      const indeterminate = table.getIsSomePageRowsSelected();

      return checked || indeterminate ? (
        <DataTableRowMenu routes={routes} table={table} />
      ) : null;
    },
    cell: ({ row }) => {
      return <DataTableRowMenu id={row.original.id} routes={routes} />;
    },
    enableHiding: false,
    enableSorting: false,
  };
}

export default getMenuColumn;

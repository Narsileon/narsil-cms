import { ColumnDef } from "@tanstack/react-table";

import { DataTable } from "@narsil-cms/blocks";
import { Checkbox } from "@narsil-cms/blocks/fields";
import {
  DataTableProvider,
  DataTableRowMenu,
} from "@narsil-cms/components/data-table";
import type {
  DataTableCollection,
  DataTableFilterCollection,
} from "@narsil-cms/types";

type ResourceIndexProps = {
  collection: DataTableCollection;
  collectionFilter: DataTableFilterCollection;
  title: string;
};

function getMenuColumn(collection: DataTableCollection): ColumnDef<unknown> {
  return {
    id: "_menu",
    header: ({ table }) =>
      table.getIsSomePageRowsSelected() || table.getIsAllPageRowsSelected() ? (
        <DataTableRowMenu
          className="absolute top-1/2 right-1 -translate-y-1/2 transform"
          routes={collection.meta.routes}
          table={table}
        />
      ) : null,
    cell: ({ row }: any) => (
      <DataTableRowMenu
        className="absolute top-1/2 right-1 -translate-y-1/2 transform"
        id={row.original.id}
        routes={collection.meta.routes}
      />
    ),
    position: "sticky",
    size: 45,
    enableSorting: false,
    enableHiding: false,
  };
}

function getSelectColumn(collection: DataTableCollection): ColumnDef<unknown> {
  return {
    id: "_select",
    header: ({ table }) =>
      collection.data.length > 0 ? (
        <Checkbox
          checked={
            table.getIsAllPageRowsSelected() ||
            (table.getIsSomePageRowsSelected() && "indeterminate")
          }
          onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
          aria-label="Select all"
        />
      ) : null,
    cell: ({ row }) => (
      <Checkbox
        checked={row.getIsSelected()}
        onCheckedChange={(value) => row.toggleSelected(!!value)}
        aria-label="Select row"
      />
    ),
    size: 32,
    enableSorting: false,
    enableHiding: false,
  };
}

function ResourceIndex({ collection, title }: ResourceIndexProps) {
  const hasMenu = collection.meta.routes.edit || collection.meta.routes.destroy;

  const finalColumns: (ColumnDef<unknown> & { position?: string })[] = [
    ...(collection.meta.selectable !== false
      ? [getSelectColumn(collection)]
      : []),
    ...collection.columns,
    ...(hasMenu ? [getMenuColumn(collection)] : []),
  ];

  const finalColumnOrder = [
    ...(collection.meta.selectable !== false ? ["_select"] : []),
    ...collection.columnOrder,
    ...(hasMenu ? ["_menu"] : []),
  ];

  return (
    <DataTableProvider
      id={collection.meta.id}
      data={collection.data}
      columns={finalColumns}
      initialState={{
        columnOrder: finalColumnOrder,
        columnVisibility: collection.columnVisibility,
      }}
    >
      <DataTable collection={collection} title={title} />
    </DataTableProvider>
  );
}

export default ResourceIndex;

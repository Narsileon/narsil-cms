import { ColumnDef } from "@tanstack/react-table";

import { DataTable } from "@narsil-cms/blocks";
import {
  DataTableProvider,
  getMenuColumn,
  getSelectColumn,
} from "@narsil-cms/components/data-table";
import type {
  Model,
  DataTableCollection,
  DataTableFilterCollection,
} from "@narsil-cms/types";

type ResourceIndexProps = {
  collection: DataTableCollection;
  collectionFilter: DataTableFilterCollection;
  title: string;
};

function ResourceIndex({ collection, title }: ResourceIndexProps) {
  const hasMenu = collection.meta.routes.edit || collection.meta.routes.destroy;

  const finalColumns: ColumnDef<Model>[] = [
    ...(collection.meta.selectable !== false
      ? [getSelectColumn(collection.data.length)]
      : []),
    ...collection.columns,
    ...(hasMenu ? [getMenuColumn(collection.meta.routes)] : []),
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

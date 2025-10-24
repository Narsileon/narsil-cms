import { DataTable } from "@narsil-cms/blocks";
import {
  DataTableProvider,
  getBulletColumn,
  getMenuColumn,
  getSelectColumn,
} from "@narsil-cms/components/data-table";
import type { DataTableCollection, Model } from "@narsil-cms/types";
import { ColumnDef } from "@tanstack/react-table";

type ResourceIndexProps = {
  collection: DataTableCollection;
  title: string;
};

function ResourceIndex({ collection, title }: ResourceIndexProps) {
  const hasMenu = collection.meta.routes.edit || collection.meta.routes.destroy;

  const bulletColumn = getBulletColumn();
  const menuColumn = getMenuColumn(collection.meta.routes);
  const selectColumn = getSelectColumn();

  const finalColumns: ColumnDef<Model>[] = [
    ...(collection.meta.selectable !== false ? [selectColumn] : []),
    ...(collection.meta.revisionable === true ? [bulletColumn] : []),
    ...collection.columns,
    ...(hasMenu ? [menuColumn] : []),
  ];

  const finalColumnOrder = [
    ...(collection.meta.selectable !== false ? ["_select"] : []),
    ...(collection.meta.revisionable === true ? ["_bullet"] : []),
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

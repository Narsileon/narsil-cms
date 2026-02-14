import { DataTable } from "@narsil-cms/blocks/data-table";
import { getMenuColumn, getSelectColumn, getStatusColumn } from "@narsil-cms/components/data-table";
import type { DataTableCollection, Model } from "@narsil-cms/types";
import { DataTableProvider } from "@narsil-ui/components/data-table";
import { ColumnDef } from "@tanstack/react-table";

type ResourceIndexProps = {
  collection: DataTableCollection;
  title: string;
};

function ResourceIndex({ collection, title }: ResourceIndexProps) {
  const hasMenu = collection.meta.routes.edit || collection.meta.routes.destroy;

  const menuColumn = getMenuColumn(collection.meta.routes);
  const selectColumn = getSelectColumn();
  const statusColumn = getStatusColumn();

  const finalColumns: ColumnDef<Model>[] = [
    ...(collection.meta.selectable !== false ? [selectColumn] : []),
    ...(collection.meta.revisionable === true ? [statusColumn] : []),
    ...collection.columns,
    ...(hasMenu ? [menuColumn] : []),
  ];
  return (
    <DataTableProvider
      data={collection.data}
      columns={finalColumns}
      initialState={collection.meta.tanStackTable}
    >
      <DataTable collection={collection} title={title} />
    </DataTableProvider>
  );
}

export default ResourceIndex;

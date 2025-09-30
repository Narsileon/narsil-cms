import { Pagination } from "@narsil-cms/blocks";
import { Select } from "@narsil-cms/blocks/fields";
import { useDataTable } from "@narsil-cms/components/data-table";
import { useLabels } from "@narsil-cms/components/labels";
import type { DataTableCollection } from "@narsil-cms/types";

type DataTableProps = {
  collection: DataTableCollection;
};

function DataTableFooter({ collection }: DataTableProps) {
  const { trans } = useLabels();

  const { dataTable, dataTableStore } = useDataTable();

  const selectedCount = dataTable.getSelectedRowModel().rows.length;

  return (
    <div className="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <span className="truncate">
        {selectedCount > 0
          ? `${selectedCount} ${trans("pagination.selected_count")}`
          : trans("pagination.selected_empty")}
      </span>
      <div className="flex w-full items-center justify-between gap-4 sm:w-fit sm:justify-end">
        <div className="flex flex-col items-start gap-x-4 gap-y-2 sm:flex-row sm:items-center">
          <span className="truncate">{trans("pagination.pagination")}</span>
          <Select
            options={["10", "25", "50", "100"]}
            value={dataTableStore.pageSize.toString()}
            onValueChange={(value) => dataTableStore.setPageSize(Number(value))}
          />
        </div>
        <div className="flex flex-col items-end gap-x-4 gap-y-2 sm:flex-row sm:items-center">
          <span className="truncate">
            {collection.meta.total > 0
              ? trans("pagination.pages_count")
              : trans("pagination.pages_empty")}
          </span>
          <Pagination links={collection.links} />
        </div>
      </div>
    </div>
  );
}

export default DataTableFooter;

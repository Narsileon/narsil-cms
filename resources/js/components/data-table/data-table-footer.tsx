import { Select } from "@narsil-cms/blocks/fields/select";
import { Pagination } from "@narsil-cms/blocks/pagination";
import { useDataTable } from "@narsil-cms/components/data-table";
import type { DataTableCollection } from "@narsil-cms/types";
import { useTranslator } from "@narsil-ui/components/translator";

type DataTableProps = {
  collection: DataTableCollection;
};

function DataTableFooter({ collection }: DataTableProps) {
  const { trans } = useTranslator();

  const { dataTable, dataTableStore } = useDataTable();

  const selectedCount = dataTable.getSelectedRowModel().rows.length;

  return (
    <div className="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <span className="truncate">
        {selectedCount > 0
          ? trans("pagination.selected_count", {
              replacements: {
                selected: selectedCount,
                total: collection.meta.total,
              },
            })
          : trans("pagination.selected_empty")}
      </span>
      <div className="flex w-full items-center justify-between gap-4 sm:w-fit sm:justify-end">
        <div className="flex flex-col items-start gap-x-4 gap-y-2 sm:flex-row sm:items-center">
          <span className="truncate">{trans("pagination.pagination")}</span>
          <Select
            options={["10", "25", "50", "100"]}
            triggerProps={{
              "aria-label": trans("pagination.pagination"),
            }}
            value={dataTableStore.pageSize.toString()}
            onValueChange={(value) => dataTableStore.setPageSize(Number(value))}
          />
        </div>
        <div className="flex flex-col items-end gap-x-4 gap-y-2 sm:flex-row sm:items-center">
          <span className="truncate">
            {collection.meta.total > 0
              ? trans("pagination.pages_count", {
                  replacements: {
                    current: collection.meta.current_page,
                    total: collection.meta.last_page,
                  },
                })
              : trans("pagination.pages_empty")}
          </span>
          <Pagination links={collection.links} />
        </div>
      </div>
    </div>
  );
}

export default DataTableFooter;

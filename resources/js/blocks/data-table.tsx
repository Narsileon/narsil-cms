import {
  horizontalListSortingStrategy,
  SortableContext,
} from "@dnd-kit/sortable";
import { flexRender, Table } from "@tanstack/react-table";

import {
  DataTableBody,
  DataTableCell,
  DataTableHead,
  DataTableHeader,
  DataTableRoot,
  DataTableRow,
} from "@narsil-cms/components/data-table";
import { TableCell } from "@narsil-cms/components/table";

type DataTableProps = {
  dataTable: Table<unknown>;
};

function DataTable({ dataTable }: DataTableProps) {
  return (
    <div className="overflow-x-auto rounded-md border">
      <DataTableRoot className="min-w-max">
        <DataTableHeader>
          {dataTable.getHeaderGroups().map((headerGroup) => (
            <DataTableRow key={headerGroup.id}>
              <SortableContext
                items={dataTable.getState().columnOrder}
                strategy={horizontalListSortingStrategy}
              >
                {headerGroup.headers.map((header) => {
                  if (header.isPlaceholder) {
                    return null;
                  }

                  return <DataTableHead header={header} key={header.id} />;
                })}
              </SortableContext>
            </DataTableRow>
          ))}
        </DataTableHeader>
        <DataTableBody>
          {dataTable.getRowModel().rows?.length ? (
            dataTable.getRowModel().rows.map((row) => (
              <DataTableRow selected={row.getIsSelected()} key={row.id}>
                {row.getVisibleCells().map((cell) => {
                  return (
                    <SortableContext
                      items={dataTable.getState().columnOrder}
                      strategy={horizontalListSortingStrategy}
                      key={cell.id}
                    >
                      <DataTableCell cell={cell}>
                        {flexRender(
                          cell.column.columnDef.cell,
                          cell.getContext() ?? "",
                        )}
                      </DataTableCell>
                    </SortableContext>
                  );
                })}
              </DataTableRow>
            ))
          ) : (
            <DataTableRow>
              <TableCell
                colSpan={dataTable.getVisibleFlatColumns().length}
                className="h-9"
              />
            </DataTableRow>
          )}
        </DataTableBody>
      </DataTableRoot>
    </div>
  );
}

export default DataTable;

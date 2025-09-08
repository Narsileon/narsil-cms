import { flexRender, Table } from "@tanstack/react-table";
import { ScrollArea } from "@narsil-cms/components/scroll-area";
import { TableCell } from "@narsil-cms/components/table";
import {
  DataTableBody,
  DataTableCell,
  DataTableHead,
  DataTableHeader,
  DataTableRoot,
  DataTableRow,
} from "@narsil-cms/components/data-table";
import {
  horizontalListSortingStrategy,
  SortableContext,
} from "@dnd-kit/sortable";

type DataTableProps = {
  dataTable: Table<any>;
};

function DataTable({ dataTable }: DataTableProps) {
  return (
    <ScrollArea className="rounded-md border" orientation="horizontal">
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
    </ScrollArea>
  );
}

export default DataTable;

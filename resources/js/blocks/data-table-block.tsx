import { flexRender, Table } from "@tanstack/react-table";
import { ScrollArea } from "@narsil-cms/components/ui/scroll-area";
import { TableCell } from "@narsil-cms/components/ui/table";
import {
  DataTable,
  DataTableBody,
  DataTableCell,
  DataTableHead,
  DataTableHeader,
  DataTableRow,
} from "@narsil-cms/components/ui/data-table";
import {
  horizontalListSortingStrategy,
  SortableContext,
} from "@dnd-kit/sortable";

type DataTableBlockProps = {
  dataTable: Table<any>;
};

function DataTableBlock({ dataTable }: DataTableBlockProps) {
  return (
    <ScrollArea className="rounded-md border" orientation="horizontal">
      <DataTable className="min-w-max">
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
                className="h-12"
              />
            </DataTableRow>
          )}
        </DataTableBody>
      </DataTable>
    </ScrollArea>
  );
}

export default DataTableBlock;

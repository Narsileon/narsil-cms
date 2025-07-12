import { flexRender, Table } from "@tanstack/react-table";
import { ScrollArea } from "@/components/ui/scroll-area";
import { TableCell, TableHead } from "@/components/ui/table";
import {
  DataTable,
  DataTableBody,
  DataTableCell,
  DataTableHead,
  DataTableHeader,
  DataTableRow,
} from "@/components/ui/data-table";
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

                  if (header.id === "_select") {
                    return (
                      <TableHead
                        data-slot="data-table-head"
                        className="min-w-10"
                        key={header.id}
                      />
                    );
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
              <DataTableRow
                data-state={row.getIsSelected() && "selected"}
                onClick={() => row.toggleSelected()}
                key={row.id}
              >
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
                          cell.getContext(),
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

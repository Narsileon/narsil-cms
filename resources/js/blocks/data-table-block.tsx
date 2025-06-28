import { flexRender } from "@tanstack/react-table";
import {
  DataTable,
  DataTableBody,
  DataTableCell,
  DataTableHead,
  DataTableHeader,
  DataTableProvider,
  DataTableRow,
} from "@/components/ui/data-table";
import type { DataTableProviderProps } from "@/components/ui/data-table";

type DataTableBlockProps = Omit<DataTableProviderProps, "render"> & {};

function DataTableBlock({ columns, ...props }: DataTableBlockProps) {
  return (
    <DataTableProvider
      columns={columns}
      render={({ dataTable }) => (
        <div className="rounded-md border">
          <DataTable>
            <DataTableHeader>
              {dataTable.getHeaderGroups().map((headerGroup) => (
                <DataTableRow key={headerGroup.id}>
                  {headerGroup.headers.map((header) => {
                    return (
                      <DataTableHead key={header.id}>
                        {header.isPlaceholder
                          ? null
                          : flexRender(
                              header.column.columnDef.header,
                              header.getContext(),
                            )}
                      </DataTableHead>
                    );
                  })}
                </DataTableRow>
              ))}
            </DataTableHeader>
            <DataTableBody>
              {dataTable.getRowModel().rows?.length ? (
                dataTable.getRowModel().rows.map((row) => (
                  <DataTableRow
                    key={row.id}
                    data-state={row.getIsSelected() && "selected"}
                  >
                    {row.getVisibleCells().map((cell) => (
                      <DataTableCell key={cell.id}>
                        {flexRender(
                          cell.column.columnDef.cell,
                          cell.getContext(),
                        )}
                      </DataTableCell>
                    ))}
                  </DataTableRow>
                ))
              ) : (
                <DataTableRow>
                  <DataTableCell
                    colSpan={columns.length}
                    className="h-24 text-center"
                  >
                    No results.
                  </DataTableCell>
                </DataTableRow>
              )}
            </DataTableBody>
          </DataTable>
        </div>
      )}
      {...props}
    />
  );
}

export default DataTableBlock;

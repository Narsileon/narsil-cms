import { flexRender, Table } from "@tanstack/react-table";

import {
  DataTableCell,
  DataTableHead,
  DataTableRow,
} from "@narsil-cms/components/data-table";
import {
  TableBody,
  TableCell,
  TableHeader,
  TableRoot,
} from "@narsil-cms/components/table";

type DataTableProps = {
  dataTable: Table<unknown>;
};

function DataTable({ dataTable }: DataTableProps) {
  return (
    <div className="overflow-x-auto rounded-md border">
      <TableRoot
        className="min-w-max"
        aria-colcount={dataTable.getAllColumns().length}
      >
        <TableHeader>
          {dataTable.getHeaderGroups().map((headerGroup) => (
            <DataTableRow key={headerGroup.id}>
              {headerGroup.headers.map((header) => {
                if (header.isPlaceholder) {
                  return null;
                }

                return <DataTableHead header={header} key={header.id} />;
              })}
            </DataTableRow>
          ))}
        </TableHeader>
        <TableBody>
          {dataTable.getRowModel().rows?.length ? (
            dataTable.getRowModel().rows.map((row) => (
              <DataTableRow selected={row.getIsSelected()} key={row.id}>
                {row.getVisibleCells().map((cell) => {
                  return (
                    <DataTableCell cell={cell} key={cell.id}>
                      {flexRender(
                        cell.column.columnDef.cell,
                        cell.getContext() ?? "",
                      )}
                    </DataTableCell>
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
        </TableBody>
      </TableRoot>
    </div>
  );
}

export default DataTable;

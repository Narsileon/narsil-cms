import { Checkbox } from "@/components/ui/checkbox";
import { flexRender } from "@tanstack/react-table";
import { Input } from "@/components/ui/input";
import {
  DataTable,
  DataTableBody,
  DataTableCell,
  DataTableColumnVisibility,
  DataTableHead,
  DataTableHeader,
  DataTablePageResult,
  DataTablePageSize,
  DataTablePagination,
  DataTableProvider,
  DataTableRow,
} from "@/components/ui/data-table";
import {
  Section,
  SectionContent,
  SectionFooter,
  SectionHeader,
} from "@/components/ui/section";
import {
  horizontalListSortingStrategy,
  SortableContext,
} from "@dnd-kit/sortable";
import type { DataTableProviderProps } from "@/components/ui/data-table";
import type { LaravelCollection } from "@/types/global";

type DataTableBlockProps = Omit<DataTableProviderProps, "data" | "render"> &
  LaravelCollection & {};

function DataTableBlock({
  columns,
  from,
  links,
  meta,
  to,
  total,
  ...props
}: DataTableBlockProps) {
  const finalColumns = [
    {
      id: "select",
      cell: ({ row }: any) => (
        <Checkbox
          checked={row.getIsSelected()}
          onCheckedChange={(value) => row.toggleSelected(!!value)}
          aria-label="Select row"
        />
      ),
      enableSorting: false,
      enableHiding: false,
    },
    ...columns,
  ];

  return (
    <DataTableProvider
      columns={finalColumns}
      render={({ dataTable, dataTableStore }) => {
        return (
          <Section>
            <SectionHeader className="flex items-center justify-between gap-4">
              <Input
                value={dataTableStore.globalFilter}
                onChange={(e) => dataTableStore.setGlobalFilter(e.target.value)}
              />
              <DataTableColumnVisibility />
            </SectionHeader>
            <SectionContent className="rounded-md border">
              <DataTable>
                <DataTableHeader>
                  {dataTable.getHeaderGroups().map((headerGroup) => (
                    <DataTableRow key={headerGroup.id}>
                      <SortableContext
                        items={dataTable.getState().columnOrder}
                        strategy={horizontalListSortingStrategy}
                      >
                        {headerGroup.headers.map((header) => {
                          return !header.isPlaceholder ? (
                            <DataTableHead header={header} key={header.id} />
                          ) : null;
                        })}
                      </SortableContext>
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
                        colSpan={finalColumns.length}
                        className="h-24 text-center"
                      >
                        No results.
                      </DataTableCell>
                    </DataTableRow>
                  )}
                </DataTableBody>
              </DataTable>
            </SectionContent>
            <SectionFooter>
              <DataTablePageResult from={from} to={to} total={total} />
              <DataTablePagination links={links} metaLinks={meta.links} />
              <DataTablePageSize />
            </SectionFooter>
          </Section>
        );
      }}
      {...props}
    />
  );
}

export default DataTableBlock;

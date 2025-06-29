import { Checkbox } from "@/components/ui/checkbox";
import { flexRender } from "@tanstack/react-table";
import { Input } from "@/components/ui/input";
import { ScrollArea } from "@/components/ui/scroll-area";
import { TableHead } from "@/components/ui/table";
import useTranslationsStore from "@/stores/translations-store";
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

type DataTableBlockProps = Omit<
  DataTableProviderProps,
  "data" | "initialState" | "render"
> &
  LaravelCollection & {};

function DataTableBlock({
  columns,
  columnVisibility,
  from,
  links,
  meta,
  to,
  total,
  ...props
}: DataTableBlockProps) {
  const { trans } = useTranslationsStore();

  const finalColumns = [
    {
      id: "_select",
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
      initialState={{
        columnVisibility: columnVisibility,
      }}
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
            <SectionContent>
              <ScrollArea
                className="rounded-md border"
                orientation="horizontal"
              >
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
                                />
                              );
                            }

                            return (
                              <DataTableHead header={header} key={header.id} />
                            );
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
                          className="h-12"
                        ></DataTableCell>
                      </DataTableRow>
                    )}
                  </DataTableBody>
                </DataTable>
              </ScrollArea>
            </SectionContent>
            <SectionFooter className="grid grid-cols-2 gap-4 sm:grid-cols-4">
              <DataTablePageResult
                className="order-2 sm:order-1"
                from={from}
                to={to}
                total={total}
              />
              <DataTablePagination
                className="order-1 col-span-2 sm:order-2"
                links={links}
                metaLinks={meta.links}
              />
              <div className="order-3 flex items-center justify-end gap-1">
                <span className="truncate">
                  {trans("pagination.per_page", "Per page:")}
                </span>
                <DataTablePageSize />
              </div>
            </SectionFooter>
          </Section>
        );
      }}
      {...props}
    />
  );
}

export default DataTableBlock;

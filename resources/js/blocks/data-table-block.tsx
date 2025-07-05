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
  DataTableInput,
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
  SectionTitle,
} from "@/components/ui/section";
import {
  horizontalListSortingStrategy,
  SortableContext,
} from "@dnd-kit/sortable";
import type { DataTableProviderProps } from "@/components/ui/data-table";
import type { LaravelCollection } from "@/types/global";
import { Button } from "@/components/ui/button";
import { PlusIcon } from "lucide-react";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import { Link } from "@inertiajs/react";

type DataTableBlockProps = Omit<
  DataTableProviderProps,
  "data" | "initialState" | "render"
> &
  LaravelCollection & {
    className?: string;
    createHref: string;
    title: string;
  };

function DataTableBlock({
  createHref,
  className,
  columns,
  columnOrder,
  columnVisibility,
  links,
  meta,
  title,
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
        columnOrder: columnOrder,
        columnVisibility: columnVisibility,
      }}
      render={({ dataTable }) => {
        return (
          <Section className={className}>
            <SectionHeader className="grid grid-cols-4 items-center justify-between gap-4">
              <SectionTitle className="col-span-full" level="h2">
                {title}
              </SectionTitle>
              <DataTableColumnVisibility className="justify-self-start" />
              <DataTableInput className="col-span-2" />
              <Tooltip>
                <TooltipTrigger asChild={true}>
                  <Button
                    aria-label={trans("ui.create", "Create")}
                    className="justify-self-end"
                    size="icon"
                    variant="default"
                    asChild={true}
                  >
                    <Link href={createHref}>
                      <PlusIcon />
                    </Link>
                  </Button>
                </TooltipTrigger>
                <TooltipContent>{trans("ui.create", "Create")}</TooltipContent>
              </Tooltip>
            </SectionHeader>
            <SectionContent className="grow">
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
                                  key={header.id}
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
                from={meta.from}
                to={meta.to}
                total={meta.total}
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

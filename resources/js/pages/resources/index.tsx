import { Button } from "@narsil-cms/components/ui/button";
import { Checkbox } from "@narsil-cms/components/ui/checkbox";
import { cn } from "@narsil-cms/lib/utils";
import { Filters } from "@narsil-cms/components/ui/filters";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { DataTableBlock } from "@narsil-cms/blocks/data-table";
import { useMinSm } from "@narsil-cms/hooks/use-breakpoints";
import DataTableColumns from "@narsil-cms/components/ui/data-table/data-table-columns";
import {
  DataTableFilter,
  DataTableInput,
  DataTablePagination,
  DataTableProvider,
  DataTableRowMenu,
  DataTableSize,
} from "@narsil-cms/components/ui/data-table";
import {
  ResizableHandle,
  ResizablePanel,
  ResizablePanelGroup,
} from "@narsil-cms/components/ui/resizable";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/ui/section";
import type { ColumnDef } from "@tanstack/react-table";
import type {
  DataTableCollection,
  DataTableFilterCollection,
} from "@narsil-cms/types/collection";

type ResourceIndexProps = {
  dataTable: DataTableCollection;
  dataTableFilter: DataTableFilterCollection;
  title: string;
};

function getMenuColumn(dataTable: DataTableCollection): ColumnDef<any> {
  return {
    id: "_menu",
    header: ({ table }) =>
      table.getIsSomePageRowsSelected() || table.getIsAllPageRowsSelected() ? (
        <DataTableRowMenu
          className="absolute top-1/2 right-1 -translate-y-1/2 transform"
          routes={dataTable.meta.routes}
          table={table}
        />
      ) : null,
    cell: ({ row }: any) => (
      <DataTableRowMenu
        className="absolute top-1/2 right-1 -translate-y-1/2 transform"
        id={row.original.id}
        routes={dataTable.meta.routes}
      />
    ),
    position: "sticky",
    size: 45,
    enableSorting: false,
    enableHiding: false,
  };
}

function getSelectColumn(dataTable: DataTableCollection): ColumnDef<any> {
  return {
    id: "_select",
    header: ({ table }) =>
      dataTable.data.length > 0 ? (
        <Checkbox
          checked={
            table.getIsAllPageRowsSelected() ||
            (table.getIsSomePageRowsSelected() && "indeterminate")
          }
          onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
          aria-label="Select all"
        />
      ) : null,
    cell: ({ row }) => (
      <Checkbox
        checked={row.getIsSelected()}
        onCheckedChange={(value) => row.toggleSelected(!!value)}
        aria-label="Select row"
      />
    ),
    size: 32,
    enableSorting: false,
    enableHiding: false,
  };
}

function ResourceIndex({
  dataTable,
  dataTableFilter,
  title,
}: ResourceIndexProps) {
  const { trans } = useLabels();

  const isDesktop = useMinSm();

  const hasMenu = dataTable.meta.routes.edit || dataTable.meta.routes.destroy;

  const finalColumns: (ColumnDef<any> & { position?: string })[] = [
    ...(dataTable.meta.selectable !== false
      ? [getSelectColumn(dataTable)]
      : []),
    ...dataTable.columns,
    ...(hasMenu ? [getMenuColumn(dataTable)] : []),
  ];

  const finalColumnOrder = [
    ...(dataTable.meta.selectable !== false ? ["_select"] : []),
    ...dataTable.columnOrder,
    ...(hasMenu ? ["_menu"] : []),
  ];

  const columnsLabel = trans("ui.columns", "Columns");
  const createLabel = trans("ui.create", "Create");
  const filterLabel = trans("ui.filters", "Filters");

  return (
    <DataTableProvider
      id={dataTable.meta.id}
      data={dataTable.data}
      columns={finalColumns}
      initialState={{
        columnOrder: finalColumnOrder,
        columnVisibility: dataTable.columnVisibility,
      }}
      render={({ dataTable: table }) => {
        const selectedCount = table.getSelectedRowModel().rows.length;

        return (
          <Section className="h-full gap-4 p-4">
            <SectionHeader className="flex items-center justify-between gap-2">
              <SectionTitle level="h2" variant="h4" className="min-w-1/5">
                {title}
              </SectionTitle>
              <DataTableInput className="grow" />
              <Tooltip hidden={isDesktop} tooltip={columnsLabel}>
                <DataTableColumns>
                  <Button
                    aria-label={columnsLabel}
                    size={isDesktop ? "default" : "icon"}
                    variant="secondary"
                  >
                    <Icon name="eye" />
                    <span className="sr-only sm:not-sr-only">
                      {columnsLabel}
                    </span>
                  </Button>
                </DataTableColumns>
              </Tooltip>
              <Tooltip hidden={isDesktop} tooltip={filterLabel}>
                <Filters columns={dataTable.columns}>
                  <Button
                    aria-label={filterLabel}
                    size={isDesktop ? "default" : "icon"}
                    variant="secondary"
                  >
                    <Icon name="filter" />
                    <span className="sr-only sm:not-sr-only">
                      {filterLabel}
                    </span>
                  </Button>
                </Filters>
              </Tooltip>
              {dataTable.meta.routes.create ? (
                <Tooltip hidden={isDesktop} tooltip={createLabel}>
                  <Button
                    asChild={true}
                    aria-label={createLabel}
                    size={isDesktop ? "default" : "icon"}
                    variant="default"
                  >
                    <Link
                      href={route(
                        dataTable.meta.routes.create,
                        dataTable.meta.routes.params,
                      )}
                    >
                      <Icon name="plus" />
                      <span className="sr-only sm:not-sr-only">
                        {createLabel}
                      </span>
                    </Link>
                  </Button>
                </Tooltip>
              ) : null}
            </SectionHeader>
            <SectionContent className="grow">
              <ResizablePanelGroup
                autoSaveId={dataTable.meta.id}
                direction="horizontal"
              >
                {dataTableFilter ? (
                  <>
                    <ResizablePanel
                      className="pr-4"
                      collapsible={true}
                      defaultSize={20}
                      minSize={10}
                    >
                      <DataTableFilter {...dataTableFilter} />
                    </ResizablePanel>
                    <ResizableHandle withHandle={true} />
                  </>
                ) : null}
                <ResizablePanel
                  className={cn(
                    "flex flex-col gap-3",
                    dataTableFilter && "pl-4",
                  )}
                  collapsible={true}
                  defaultSize={80}
                  minSize={10}
                >
                  <DataTableBlock dataTable={table} />
                  <div className="flex flex-col items-start justify-between gap-4 text-sm sm:flex-row sm:items-center">
                    <span className="truncate">
                      {selectedCount > 0
                        ? `${selectedCount} ${trans("pagination.selected_count")}`
                        : trans("pagination.selected_empty")}
                    </span>
                    <div className="flex w-full items-center justify-between gap-4 sm:w-fit sm:justify-end">
                      <div className="flex flex-col items-start gap-x-4 gap-y-2 sm:flex-row sm:items-center">
                        <span className="truncate">
                          {trans("pagination.pagination")}
                        </span>
                        <DataTableSize />
                      </div>
                      <div className="flex flex-col items-end gap-x-4 gap-y-2 sm:flex-row sm:items-center">
                        <span className="truncate">
                          {dataTable.meta.total > 0
                            ? trans("pagination.pages_count")
                            : trans("pagination.pages_empty")}
                        </span>
                        <DataTablePagination links={dataTable.links} />
                      </div>
                    </div>
                  </div>
                </ResizablePanel>
              </ResizablePanelGroup>
            </SectionContent>
          </Section>
        );
      }}
    />
  );
}

export default ResourceIndex;

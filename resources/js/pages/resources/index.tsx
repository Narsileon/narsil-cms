import { Link } from "@inertiajs/react";
import { type ColumnDef } from "@tanstack/react-table";
import { route } from "ziggy-js";

import { Checkbox, DataTable, Pagination, Tooltip } from "@narsil-cms/blocks";
import { Button } from "@narsil-cms/components/button";
import {
  DataTableFilter,
  DataTableFilterBadge,
  DataTableFilterDropdown,
  DataTableInput,
  DataTableProvider,
  DataTableRowMenu,
  DataTableSize,
  DataTableVisibilityDropdown,
} from "@narsil-cms/components/data-table";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import {
  ResizableHandle,
  ResizablePanel,
  ResizablePanelGroup,
} from "@narsil-cms/components/resizable";
import {
  SectionContent,
  SectionHeader,
  SectionRoot,
  SectionTitle,
} from "@narsil-cms/components/section";
import { useMinSm } from "@narsil-cms/hooks/use-breakpoints";
import { cn } from "@narsil-cms/lib/utils";
import {
  type DataTableCollection,
  type DataTableFilterCollection,
} from "@narsil-cms/types";

type ResourceIndexProps = {
  collection: DataTableCollection;
  collectionFilter: DataTableFilterCollection;
  title: string;
};

function getMenuColumn(collection: DataTableCollection): ColumnDef<unknown> {
  return {
    id: "_menu",
    header: ({ table }) =>
      table.getIsSomePageRowsSelected() || table.getIsAllPageRowsSelected() ? (
        <DataTableRowMenu
          className="absolute top-1/2 right-1 -translate-y-1/2 transform"
          routes={collection.meta.routes}
          table={table}
        />
      ) : null,
    cell: ({ row }: any) => (
      <DataTableRowMenu
        className="absolute top-1/2 right-1 -translate-y-1/2 transform"
        id={row.original.id}
        routes={collection.meta.routes}
      />
    ),
    position: "sticky",
    size: 45,
    enableSorting: false,
    enableHiding: false,
  };
}

function getSelectColumn(collection: DataTableCollection): ColumnDef<unknown> {
  return {
    id: "_select",
    header: ({ table }) =>
      collection.data.length > 0 ? (
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
  collection,
  collectionFilter,
  title,
}: ResourceIndexProps) {
  const { trans } = useLabels();

  const isDesktop = useMinSm();

  const hasMenu = collection.meta.routes.edit || collection.meta.routes.destroy;

  const finalColumns: (ColumnDef<unknown> & { position?: string })[] = [
    ...(collection.meta.selectable !== false
      ? [getSelectColumn(collection)]
      : []),
    ...collection.columns,
    ...(hasMenu ? [getMenuColumn(collection)] : []),
  ];

  const finalColumnOrder = [
    ...(collection.meta.selectable !== false ? ["_select"] : []),
    ...collection.columnOrder,
    ...(hasMenu ? ["_menu"] : []),
  ];

  const columnsLabel = trans("ui.columns", "Columns");
  const createLabel = trans("ui.create", "Create");
  const filterLabel = trans("ui.filters", "Filters");

  return (
    <DataTableProvider
      id={collection.meta.id}
      data={collection.data}
      columns={finalColumns}
      initialState={{
        columnOrder: finalColumnOrder,
        columnVisibility: collection.columnVisibility,
      }}
      render={({ dataTable, dataTableStore }) => {
        const selectedCount = dataTable.getSelectedRowModel().rows.length;

        return (
          <SectionRoot className="h-full gap-4 p-4">
            <SectionHeader className="flex items-center justify-between gap-2">
              <SectionTitle level="h2" variant="h4" className="min-w-1/5">
                {title}
              </SectionTitle>
              <DataTableInput className="grow" />
              <Tooltip hidden={isDesktop} tooltip={columnsLabel}>
                <DataTableVisibilityDropdown>
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
                </DataTableVisibilityDropdown>
              </Tooltip>
              <Tooltip hidden={isDesktop} tooltip={filterLabel}>
                <DataTableFilterDropdown>
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
                </DataTableFilterDropdown>
              </Tooltip>
              {collection.meta.routes.create ? (
                <Tooltip hidden={isDesktop} tooltip={createLabel}>
                  <Button
                    asChild={true}
                    aria-label={createLabel}
                    size={isDesktop ? "default" : "icon"}
                    variant="default"
                  >
                    <Link
                      href={route(
                        collection.meta.routes.create,
                        collection.meta.routes.params,
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
                autoSaveId={collection.meta.id}
                direction="horizontal"
              >
                {collectionFilter ? (
                  <>
                    <ResizablePanel
                      className="pr-4"
                      collapsible={true}
                      defaultSize={20}
                      minSize={10}
                    >
                      <DataTableFilter {...collectionFilter} />
                    </ResizablePanel>
                    <ResizableHandle withHandle={true} />
                  </>
                ) : null}
                <ResizablePanel
                  className={cn(
                    "flex flex-col gap-3",
                    collectionFilter && "pl-4",
                  )}
                  collapsible={true}
                  defaultSize={80}
                  minSize={10}
                >
                  {dataTableStore.filters.length > 0 ? (
                    <ul className="flex items-center justify-start gap-2">
                      {dataTableStore.filters.map((filter, index) => {
                        return (
                          <li key={index}>
                            <DataTableFilterBadge filter={filter} />
                          </li>
                        );
                      })}
                    </ul>
                  ) : null}
                  <DataTable dataTable={dataTable} />
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
                          {collection.meta.total > 0
                            ? trans("pagination.pages_count")
                            : trans("pagination.pages_empty")}
                        </span>
                        <Pagination links={collection.links} />
                      </div>
                    </div>
                  </div>
                </ResizablePanel>
              </ResizablePanelGroup>
            </SectionContent>
          </SectionRoot>
        );
      }}
    />
  );
}

export default ResourceIndex;

import { flexRender } from "@tanstack/react-table";
import { route } from "ziggy-js";

import { Button, Heading } from "@narsil-cms/blocks";
import {
  DataTableCell,
  DataTableColumns,
  DataTableFilterDropdown,
  DataTableFilterList,
  DataTableFooter,
  DataTableHead,
  DataTableInput,
  DataTableRow,
  useDataTable,
} from "@narsil-cms/components/data-table";
import { useLabels } from "@narsil-cms/components/labels";
import {
  SectionContent,
  SectionHeader,
  SectionRoot,
} from "@narsil-cms/components/section";
import {
  TableBody,
  TableCell,
  TableHeader,
  TableRoot,
} from "@narsil-cms/components/table";
import { useMinSm } from "@narsil-cms/hooks/use-breakpoints";
import type { DataTableCollection } from "@narsil-cms/types";

type DataTableProps = {
  collection: DataTableCollection;
  title: string;
};

function DataTable({ collection, title }: DataTableProps) {
  const { trans } = useLabels();

  const { dataTable } = useDataTable();

  const isDesktop = useMinSm();

  const columnsLabel = trans("ui.columns", "Columns");
  const createLabel = trans("ui.create", "Create");
  const filterLabel = trans("ui.filters", "Filters");

  return (
    <SectionRoot className="h-full gap-4 p-4">
      <SectionHeader className="flex items-center justify-between gap-2">
        <Heading level="h2" variant="h4" className="min-w-1/5">
          {title}
        </Heading>
        <DataTableInput className="grow" />
        <DataTableColumns>
          <Button
            icon="eye"
            size={isDesktop ? "default" : "icon"}
            tooltipProps={{
              contentProps: { hidden: isDesktop },
              tooltip: columnsLabel,
            }}
            variant="secondary"
          >
            {isDesktop ? columnsLabel : undefined}
          </Button>
        </DataTableColumns>
        <DataTableFilterDropdown>
          <Button
            icon="filter"
            size={isDesktop ? "default" : "icon"}
            tooltipProps={{
              contentProps: { hidden: isDesktop },
              tooltip: filterLabel,
            }}
            variant="secondary"
          >
            {isDesktop ? filterLabel : undefined}
          </Button>
        </DataTableFilterDropdown>
        {collection.meta.routes.create ? (
          <Button
            icon="plus"
            linkProps={{
              href: route(
                collection.meta.routes.create,
                collection.meta.routes.params,
              ),
            }}
            size={isDesktop ? "default" : "icon"}
            tooltipProps={{
              contentProps: { hidden: isDesktop },
              tooltip: createLabel,
            }}
          >
            {isDesktop ? createLabel : undefined}
          </Button>
        ) : null}
      </SectionHeader>
      <SectionContent className="flex grow flex-col gap-4">
        <DataTableFilterList />
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
        <DataTableFooter collection={collection} />
      </SectionContent>
    </SectionRoot>
  );
}

export default DataTable;

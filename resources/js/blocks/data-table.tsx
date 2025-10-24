import { router } from "@inertiajs/react";
import { Button, Heading } from "@narsil-cms/blocks";
import {
  DataTableColumns,
  DataTableFilterDropdown,
  DataTableFilterList,
  DataTableFooter,
  DataTableHead,
  DataTableInput,
  DataTableRow,
  useDataTable,
} from "@narsil-cms/components/data-table";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import {
  TableBody,
  TableCell,
  TableHeader,
  TableRoot,
  TableWrapper,
} from "@narsil-cms/components/table";
import { useMinSm } from "@narsil-cms/hooks/use-breakpoints";
import type { DataTableCollection } from "@narsil-cms/types";
import { flexRender } from "@tanstack/react-table";
import { route } from "ziggy-js";

type DataTableProps = {
  collection: DataTableCollection;
  title: string;
};

function DataTable({ collection, title }: DataTableProps) {
  const { trans } = useLocalization();

  const { dataTable } = useDataTable();

  const isDesktop = useMinSm();

  const columnsLabel = trans("ui.columns");
  const createLabel = trans("ui.create");
  const filterLabel = trans("ui.filters");

  function onRowClick(id: number) {
    if (collection.meta.routes.edit) {
      router.visit(
        route(collection.meta.routes.edit, {
          ...collection.meta.routes.params,
          id: id,
        }),
      );
    }
  }

  return (
    <SectionRoot className="h-full animate-in gap-4 p-4 duration-300 fade-in-0">
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
              href: route(collection.meta.routes.create, collection.meta.routes.params),
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
      <SectionContent className="flex grow flex-col gap-4 overflow-y-auto">
        <DataTableFilterList />
        <TableWrapper>
          <TableRoot className="min-w-max" aria-colcount={dataTable.getAllColumns().length}>
            <TableHeader>
              {dataTable.getHeaderGroups().map((headerGroup) => {
                return (
                  <DataTableRow className="bg-accent" key={headerGroup.id}>
                    {headerGroup.headers.map((header) => {
                      if (header.isPlaceholder) {
                        return null;
                      }

                      return (
                        <DataTableHead
                          className={header.column.columnDef.meta?.className}
                          header={header}
                          key={header.id}
                        />
                      );
                    })}
                  </DataTableRow>
                );
              })}
            </TableHeader>
            <TableBody>
              {dataTable.getRowModel().rows?.length ? (
                dataTable.getRowModel().rows.map((row) => {
                  return (
                    <DataTableRow
                      className="cursor-pointer"
                      onClick={() => onRowClick(row.original.id)}
                      selected={row.getIsSelected()}
                      key={row.id}
                    >
                      {row.getVisibleCells().map((cell) => {
                        return (
                          <TableCell
                            className={cell.column.columnDef.meta?.className}
                            key={cell.id}
                          >
                            {flexRender(cell.column.columnDef.cell, cell.getContext() ?? "")}
                          </TableCell>
                        );
                      })}
                    </DataTableRow>
                  );
                })
              ) : (
                <DataTableRow>
                  <TableCell colSpan={dataTable.getVisibleFlatColumns().length} className="h-9" />
                </DataTableRow>
              )}
            </TableBody>
          </TableRoot>
        </TableWrapper>
        <DataTableFooter collection={collection} />
      </SectionContent>
    </SectionRoot>
  );
}

export default DataTable;

import { Link, router } from "@inertiajs/react";
import type { DataTableCollection } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import {
  DataTableColumnFilters,
  DataTableFilterList,
  DataTableFooter,
  DataTableHead,
  DataTableInput,
  DataTableRow,
  DataTableSettings,
  useDataTable,
} from "@narsil-ui/components/data-table";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-ui/components/section";
import {
  TableBody,
  TableCell,
  TableHeader,
  TableRoot,
  TableWrapper,
} from "@narsil-ui/components/table";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { useMinSm } from "@narsil-ui/hooks/use-breakpoints";
import { flexRender } from "@tanstack/react-table";
import { route } from "ziggy-js";

type DataTableProps = {
  collection: DataTableCollection;
  title: string;
};

function DataTable({ collection, title }: DataTableProps) {
  const { trans } = useTranslator();

  const table = useDataTable();

  const isDesktop = useMinSm();

  const createLabel = trans("ui.create");
  const filterLabel = trans("data-table.filters");

  function handleCreate() {
    if (collection.meta.routes.create) {
      router.visit(
        route(collection.meta.routes.create, {
          ...collection.meta.routes.params,
        }),
      );
    }
  }

  function handleEdit(id: number) {
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
    <SectionRoot className="h-full animate-in gap-4 p-4 fade-in-0">
      <SectionHeader className="flex items-center justify-between gap-2">
        <Heading level="h2" variant="h4" className="min-w-1/5">
          {title}
        </Heading>
        <div className="flex grow items-center justify-end gap-2">
          <DataTableInput />
          <Tooltip hidden={isDesktop} tooltip={filterLabel}>
            <DataTableColumnFilters
              render={
                <Button
                  aria-label={filterLabel}
                  size={isDesktop ? "default" : "icon"}
                  variant="secondary"
                >
                  <Icon name="filter" />
                  {isDesktop ? filterLabel : undefined}
                </Button>
              }
            />
          </Tooltip>
          {collection.meta.routes.create ? (
            <Tooltip hidden={isDesktop} tooltip={createLabel}>
              <Button
                aria-label={createLabel}
                nativeButton={false}
                size={isDesktop ? "default" : "icon"}
                render={
                  <Link href={route(collection.meta.routes.create, collection.meta.routes.params)}>
                    <Icon name="plus" />
                    {isDesktop ? createLabel : undefined}
                  </Link>
                }
              />
            </Tooltip>
          ) : null}
          <DataTableSettings />
        </div>
      </SectionHeader>
      <SectionContent className="flex grow flex-col gap-4 overflow-y-auto">
        <DataTableFilterList />
        <TableWrapper>
          <TableRoot className="min-w-max" aria-colcount={table.getAllColumns().length}>
            <TableHeader>
              {table.getHeaderGroups().map((headerGroup) => {
                return (
                  <DataTableRow className="sticky top-0 z-10 bg-accent" key={headerGroup.id}>
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
              {table.getRowModel().rows?.length ? (
                table.getRowModel().rows.map((row) => {
                  return (
                    <DataTableRow
                      className="cursor-pointer"
                      onClick={() => handleEdit(row.original.id)}
                      selected={row.getIsSelected()}
                      key={row.id}
                    >
                      {row.getVisibleCells().map((cell) => {
                        let content = null;

                        if (cell.column.columnDef.meta?.type === "bool") {
                          content = cell.getValue() ? (
                            <Icon className="text-constructive" name="check" />
                          ) : (
                            <Icon className="text-destructive" name="x" />
                          );
                        } else {
                          content = flexRender(cell.column.columnDef.cell, cell.getContext() ?? "");
                        }

                        return (
                          <TableCell
                            className={cell.column.columnDef.meta?.className}
                            key={cell.id}
                          >
                            {content}
                          </TableCell>
                        );
                      })}
                    </DataTableRow>
                  );
                })
              ) : (
                <DataTableRow className="cursor-pointer" onClick={() => handleCreate()}>
                  <TableCell colSpan={table.getVisibleFlatColumns().length} className="h-9" />
                </DataTableRow>
              )}
            </TableBody>
          </TableRoot>
        </TableWrapper>
        <DataTableFooter links={collection.links} meta={collection.meta} />
      </SectionContent>
    </SectionRoot>
  );
}

export default DataTable;

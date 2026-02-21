import { Link } from "@inertiajs/react";
import { getStatusColumn } from "@narsil-cms/components/data-table";
import { Button } from "@narsil-ui/components/button";
import {
  type TableData,
  DataTable,
  DataTableProvider,
  getMenuColumn,
  getSelectColumn,
} from "@narsil-ui/components/data-table";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-ui/components/section";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { useMinSm } from "@narsil-ui/hooks/use-breakpoints";
import type { DataTableCollection } from "@narsil-ui/types";
import { ColumnDef } from "@tanstack/react-table";
import { route } from "ziggy-js";

type ResourceIndexProps = {
  collection: DataTableCollection;
  title: string;
};

function ResourceIndex({ collection, title }: ResourceIndexProps) {
  const { trans } = useTranslator();

  const isDesktop = useMinSm();

  const createLabel = trans("ui.create");

  const hasMenu = collection.meta.routes.edit || collection.meta.routes.destroy;

  const menuColumn = getMenuColumn(collection.meta.routes);
  const selectColumn = getSelectColumn();
  const statusColumn = getStatusColumn();

  const finalColumns: ColumnDef<TableData>[] = [
    ...(collection.meta.selectable !== false ? [selectColumn] : []),
    ...(collection.meta.revisionable === true ? [statusColumn] : []),
    ...collection.meta.columns,
    ...(hasMenu ? [menuColumn] : []),
  ];
  return (
    <DataTableProvider
      data={collection.data}
      columns={finalColumns}
      initialState={collection.meta.tableData}
    >
      <SectionRoot className="h-full animate-in gap-4 p-4 fade-in-0">
        <SectionHeader className="flex items-center justify-between gap-2">
          <Heading level="h2" variant="h4" className="min-w-1/5">
            {title}
          </Heading>
          {collection.meta.routes.create ? (
            <Tooltip hidden={isDesktop} tooltip={createLabel}>
              <Button
                aria-label={createLabel}
                nativeButton={false}
                size={isDesktop ? "default" : "icon"}
                render={
                  <Link
                    href={route(collection.meta.routes.create, collection.meta.routes.parameters)}
                  >
                    <Icon name="plus" />
                    {isDesktop ? createLabel : undefined}
                  </Link>
                }
              />
            </Tooltip>
          ) : null}
        </SectionHeader>
        <SectionContent
          className="grow overflow-y-auto"
          render={<DataTable collection={collection} />}
        />
      </SectionRoot>
    </DataTableProvider>
  );
}

export default ResourceIndex;

import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { cn } from "@/lib/utils";
import { Link } from "@inertiajs/react";
import { PlusIcon } from "lucide-react";
import { route } from "ziggy-js";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import DataTableBlock from "@/blocks/data-table-block";
import DataTableFilter from "@/blocks/data-table-filter";
import {
  DataTableInput,
  DataTablePagination,
  DataTableProvider,
  DataTableRowMenu,
  DataTableSettings,
} from "@/components/ui/data-table";
import {
  ResizableHandle,
  ResizablePanel,
  ResizablePanelGroup,
} from "@/components/ui/resizable";
import {
  Section,
  SectionContent,
  SectionFooter,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { DataTableCollection, DataTableFilterCollection } from "@/types";

type ResourceIndexProps = {
  dataTable: DataTableCollection;
  dataTableFilter: DataTableFilterCollection;
};

function ResourceIndex({ dataTable, dataTableFilter }: ResourceIndexProps) {
  const { getLabel } = useLabels();

  const finalColumns = [
    {
      id: "_select",
      cell: ({ row }: any) => (
        <Checkbox
          className="mx-1"
          checked={row.getIsSelected()}
          onCheckedChange={(value) => row.toggleSelected(!!value)}
          aria-label="Select row"
        />
      ),
      size: 32,
      enableSorting: false,
      enableHiding: false,
    },
    ...dataTable.columns,
    {
      id: "_menu",
      cell: ({ row }: any) => (
        <DataTableRowMenu
          className="absolute top-1/2 right-1 -translate-y-1/2 transform"
          id={row.original.id}
          routes={dataTable.meta.routes}
        />
      ),
      position: "sticky",
      size: 32,
      enableSorting: false,
      enableHiding: false,
    },
  ];

  const finalColumnOrder = ["_select", ...dataTable.columnOrder];

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
        return (
          <Section className="h-full gap-3 p-4">
            <SectionHeader className="flex items-center justify-between gap-3">
              <SectionTitle level="h2" variant="h4" className="min-w-1/5">
                {dataTable.meta.title}
              </SectionTitle>
              <DataTableInput className="ml-2 grow" />
              {dataTable.meta.routes.create ? (
                <Tooltip tooltip={getLabel("ui.create")}>
                  <Button
                    aria-label={getLabel("ui.create", "Create")}
                    size="icon"
                    variant="default"
                    asChild={true}
                  >
                    <Link href={route(dataTable.meta.routes.create)}>
                      <PlusIcon />
                    </Link>
                  </Button>
                </Tooltip>
              ) : null}
              <DataTableSettings />
            </SectionHeader>
            <SectionContent className="grow">
              <ResizablePanelGroup
                autoSaveId={dataTable.meta.id}
                direction="horizontal"
              >
                {dataTableFilter ? (
                  <>
                    <ResizablePanel
                      className="pr-3"
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
                    dataTableFilter && "pl-3",
                  )}
                  collapsible={true}
                  defaultSize={80}
                  minSize={10}
                >
                  <DataTableBlock dataTable={table} />
                </ResizablePanel>
              </ResizablePanelGroup>
            </SectionContent>
            <SectionFooter className="grid grid-cols-2 gap-4 sm:grid-cols-4">
              <span className="order-2 min-w-fit truncate text-sm sm:order-1">
                {getLabel("pagination.results")}
              </span>
              <DataTablePagination
                className="order-1 col-span-2 sm:order-2"
                links={dataTable.links}
                metaLinks={dataTable.meta.links}
              />
            </SectionFooter>
          </Section>
        );
      }}
    />
  );
}

export default ResourceIndex;

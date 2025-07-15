import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { Link } from "@inertiajs/react";
import { PlusIcon } from "lucide-react";
import { route } from "ziggy-js";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import CategoriesBlock from "@/blocks/categories-block";
import DataTableBlock from "@/blocks/data-table-block";
import {
  DataTableInput,
  DataTablePagination,
  DataTableProvider,
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
import type { CategoriesCollection, DataTableCollection } from "@/types";

type ResourceIndexProps = {
  categories: CategoriesCollection;
  dataTable: DataTableCollection;
};

function ResourceIndex({ categories, dataTable }: ResourceIndexProps) {
  const { getLabel } = useLabels();

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
      size: 32,
      enableSorting: false,
      enableHiding: false,
    },
    ...dataTable.columns,
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
          <Section className="h-full p-4">
            <SectionHeader>
              <SectionTitle level="h2" variant="h4">
                {dataTable.meta.title}
              </SectionTitle>
            </SectionHeader>
            <SectionContent className="grow">
              <ResizablePanelGroup
                autoSaveId={dataTable.meta.id}
                direction="horizontal"
              >
                <ResizablePanel
                  className="px-4 py-1"
                  collapsible={true}
                  defaultSize={20}
                  minSize={10}
                >
                  <CategoriesBlock {...categories} />
                </ResizablePanel>
                <ResizableHandle withHandle={true} />
                <ResizablePanel
                  className="flex flex-col gap-3 px-4 py-1"
                  collapsible={true}
                  defaultSize={80}
                  minSize={10}
                >
                  <div className="flex items-center justify-between gap-3">
                    <DataTableInput className="grow" />
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
                  </div>
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

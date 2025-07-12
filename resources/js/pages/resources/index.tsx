import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { Link } from "@inertiajs/react";
import { PlusIcon } from "lucide-react";
import { route } from "ziggy-js";
import { Tooltip } from "@/components/ui/tooltip";
import CategoriesBlock from "@/blocks/categories-block";
import DataTableBlock from "@/blocks/data-table-block";
import useTranslationsStore from "@/stores/translations-store";
import {
  DataTableColumnVisibility,
  DataTableInput,
  DataTablePageResult,
  DataTablePageSize,
  DataTablePagination,
  DataTableProvider,
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
import type { CategoriesCollection, DataTableCollection } from "@/types/global";

type ResourceIndexProps = {
  categories: CategoriesCollection;
  dataTable: DataTableCollection;
};

function ResourceIndex({ categories, dataTable }: ResourceIndexProps) {
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
      size: 32,
      enableSorting: false,
      enableHiding: false,
    },
    ...dataTable.columns,
  ];

  const finalColumnOrder = ["_select", ...dataTable.columnOrder];

  return (
    <DataTableProvider
      id=""
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
                autoSaveId={dataTable.meta.title}
                direction="horizontal"
              >
                <ResizablePanel
                  collapsible={true}
                  defaultSize={20}
                  minSize={10}
                >
                  <CategoriesBlock {...categories} />
                </ResizablePanel>
                <ResizableHandle withHandle={true} className="mx-3" />
                <ResizablePanel
                  className="flex flex-col gap-3"
                  collapsible={true}
                  defaultSize={80}
                  minSize={40}
                >
                  <div className="flex items-center justify-between gap-3 py-1">
                    <DataTableColumnVisibility />
                    <DataTableInput className="grow" />
                    {dataTable.meta.routes.create ? (
                      <Tooltip tooltip={trans("ui.create", "Create")}>
                        <Button
                          aria-label={trans("ui.create", "Create")}
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
                  </div>
                  <DataTableBlock dataTable={table} />
                </ResizablePanel>
              </ResizablePanelGroup>
            </SectionContent>
            <SectionFooter className="grid grid-cols-2 gap-4 sm:grid-cols-4">
              <DataTablePageResult
                className="order-2 sm:order-1"
                from={dataTable.meta.from}
                to={dataTable.meta.to}
                total={dataTable.meta.total}
              />
              <DataTablePagination
                className="order-1 col-span-2 sm:order-2"
                links={dataTable.links}
                metaLinks={dataTable.meta.links}
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
    />
  );
}

export default ResourceIndex;

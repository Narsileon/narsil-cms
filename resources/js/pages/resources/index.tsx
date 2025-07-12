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
                {dataTable.translations.title}
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
                    <DataTableSettings
                      columnsLabel={dataTable.translations.columns}
                      paginationLabel={dataTable.translations.pagination}
                      triggerTooltip={dataTable.translations.toggle_settings}
                    />
                  </div>
                  <DataTableBlock
                    dataTable={table}
                    moveLabel={dataTable.translations.move_columns}
                    sortLabel={dataTable.translations.sort_columns}
                  />
                </ResizablePanel>
              </ResizablePanelGroup>
            </SectionContent>
            <SectionFooter className="grid grid-cols-2 gap-4 sm:grid-cols-4">
              <span className="order-2 min-w-fit truncate text-sm sm:order-1">
                {dataTable.translations.results}
              </span>
              <DataTablePagination
                className="order-1 col-span-2 sm:order-2"
                ellipsisLabel={dataTable.translations.more_pages}
                firstPageLabel={dataTable.translations.first_page}
                lastPageLabel={dataTable.translations.last_page}
                links={dataTable.links}
                metaLinks={dataTable.meta.links}
                nextPageLabel={dataTable.translations.next_page}
                previousPageLabel={dataTable.translations.previous_page}
              />
            </SectionFooter>
          </Section>
        );
      }}
    />
  );
}

export default ResourceIndex;

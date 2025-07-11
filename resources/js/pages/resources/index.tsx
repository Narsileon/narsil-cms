import {
  ResizableHandle,
  ResizablePanel,
  ResizablePanelGroup,
} from "@/components/ui/resizable";
import { route } from "ziggy-js";
import CategoriesBlock from "@/blocks/categories-block";
import DataTableBlock from "@/blocks/data-table-block";
import useTranslationsStore from "@/stores/translations-store";
import type { CategoriesCollection, DataTableCollection } from "@/types/global";

type ResourceIndexProps = {
  categories: CategoriesCollection;
  dataTable: DataTableCollection;
};

function ResourceIndex({ categories, dataTable }: ResourceIndexProps) {
  const { trans } = useTranslationsStore();

  return (
    <ResizablePanelGroup autoSaveId="resource-index" direction="horizontal">
      {categories ? (
        <>
          <ResizablePanel collapsible={true} defaultSize={20} minSize={10}>
            <CategoriesBlock className="p-4" {...categories} />
          </ResizablePanel>
          <ResizableHandle withHandle={true} />
        </>
      ) : null}
      <ResizablePanel collapsible={true} defaultSize={80} minSize={40}>
        <DataTableBlock
          id="sites"
          className="h-full p-4"
          createHref={route("sites.create")}
          title={trans("ui.sites", "Sites")}
          {...dataTable}
        />
      </ResizablePanel>
    </ResizablePanelGroup>
  );
}

export default ResourceIndex;

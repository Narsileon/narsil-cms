import { Button } from "@/components/ui/button";
import { ResizablePanel, ResizablePanelGroup } from "@/components/ui/resizable";
import { route } from "ziggy-js";
import { useModalStore } from "@/stores/modal-store";
import DataTableBlock from "@/blocks/data-table-block";
import useTranslationsStore from "@/stores/translations-store";
import {
  Section,
  SectionContent,
  SectionFooter,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { LaravelCollection, LaravelForm } from "@/types/global";

type ResourceIndexProps = {
  form: LaravelForm;
  collection: LaravelCollection;
};

function ResourceIndex({ collection }: ResourceIndexProps) {
  const { openModal } = useModalStore();
  const { trans } = useTranslationsStore();

  return (
    <ResizablePanelGroup autoSaveId="resource-index" direction="horizontal">
      <ResizablePanel collapsible={true} defaultSize={20} minSize={10}>
        <Section>
          <SectionHeader>
            <SectionTitle level="h2">
              {trans("ui.groups", "Groups")}
            </SectionTitle>
            <SectionContent></SectionContent>
            <SectionFooter>
              <Button onClick={() => openModal(route("site-groups.create"))}>
                Test
              </Button>
            </SectionFooter>
          </SectionHeader>
        </Section>
      </ResizablePanel>
      <ResizablePanel collapsible={true} defaultSize={80} minSize={40}>
        <DataTableBlock
          id="sites"
          className="col-span-3 h-full p-4"
          createHref={route("sites.create")}
          title={trans("ui.sites", "Sites")}
          {...collection}
        />
      </ResizablePanel>
    </ResizablePanelGroup>
  );
}

export default ResourceIndex;

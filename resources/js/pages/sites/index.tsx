import { Button } from "@/components/ui/button";
import { route } from "ziggy-js";
import DataTableBlock from "@/blocks/data-table-block";
import useTranslationsStore from "@/stores/translations-store";
import {
  Section,
  SectionContent,
  SectionFooter,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { LaravelCollection } from "@/types/global";

type IndexProps = {
  groups: LaravelCollection;
  sites: LaravelCollection;
};

function Index({ groups, sites }: IndexProps) {
  const { trans } = useTranslationsStore();

  return (
    <div className="grid h-full grid-cols-4 items-start justify-between">
      <Section className="bg-muted h-full p-4">
        <SectionHeader>
          <SectionTitle level="h2">{trans("ui.groups", "Groups")}</SectionTitle>
        </SectionHeader>
        <SectionContent>
          {groups.data.map((group, index) => (
            <Button variant="ghost" key={index}>
              {group.name}
            </Button>
          ))}
        </SectionContent>
        <SectionFooter>
          <Button className="w-full" variant="default">
            {trans("ui.create", "Create")}
          </Button>
        </SectionFooter>
      </Section>

      <DataTableBlock
        id="sites"
        className="col-span-3 h-full p-4"
        createHref={route("sites.create")}
        title={trans("ui.sites", "Sites")}
        {...sites}
      />
    </div>
  );
}

export default Index;

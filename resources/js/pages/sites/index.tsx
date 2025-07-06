import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { route } from "ziggy-js";
import { useMinMd } from "@/hooks/use-breakpoints";
import { useState } from "react";
import DataTableBlock from "@/blocks/data-table-block";
import useTranslationsStore from "@/stores/translations-store";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
  FormProvider,
  FormSubmit,
} from "@/components/ui/form";
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
import type { LaravelCollection } from "@/types/global";

type IndexProps = {
  groups: LaravelCollection;
  sites: LaravelCollection;
};

function Index({ groups, sites }: IndexProps) {
  const { trans } = useTranslationsStore();

  const minMd = useMinMd();

  const [open, onOpenChange] = useState<boolean>(false);

  return (
    <>
      <ResizablePanelGroup
        autoSaveId="sites"
        direction={minMd ? "horizontal" : "vertical"}
      >
        <ResizablePanel collapsible={true} defaultSize={20} minSize={10}>
          <Section className="bg-muted h-full p-4">
            <SectionHeader>
              <SectionTitle level="h2">
                {trans("ui.groups", "Groups")}
              </SectionTitle>
            </SectionHeader>
            <SectionContent>
              {groups.data.map((group, index) => (
                <Button variant="ghost" key={index}>
                  {group.name}
                </Button>
              ))}
            </SectionContent>
            <SectionFooter>
              <Button
                className="w-full"
                variant="default"
                onClick={() => onOpenChange(true)}
              >
                {trans("ui.create", "Create")}
              </Button>
            </SectionFooter>
          </Section>
        </ResizablePanel>
        <ResizableHandle withHandle={true} />
        <ResizablePanel collapsible={true} defaultSize={80} minSize={40}>
          <DataTableBlock
            id="sites"
            className="col-span-3 h-full p-4"
            createHref={route("sites.create")}
            title={trans("ui.sites", "Sites")}
            {...sites}
          />
        </ResizablePanel>
      </ResizablePanelGroup>
      <Dialog open={open} onOpenChange={onOpenChange}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>{trans("ui.group", "Group")}</DialogTitle>
          </DialogHeader>
          <FormProvider
            id="site-group-form"
            initialData={{
              name: "",
            }}
            render={() => (
              <Form
                className="grid gap-6"
                method="post"
                url={route("register.store")}
              >
                <FormField
                  name="name"
                  render={({ onChange, ...field }) => (
                    <FormItem>
                      <FormLabel required={true} />
                      <Input
                        onChange={(e) => onChange(e.target.value)}
                        {...field}
                      />
                      <FormMessage />
                    </FormItem>
                  )}
                />
                <FormSubmit className="col-span-full">
                  {trans("ui.save", "Save")}
                </FormSubmit>
              </Form>
            )}
          />
        </DialogContent>
      </Dialog>
    </>
  );
}

export default Index;

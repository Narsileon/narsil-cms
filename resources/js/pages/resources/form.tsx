import { Button, Card, Heading, RevisionSelect, SaveButton } from "@narsil-cms/blocks";
import { DialogBody, DialogClose, DialogFooter } from "@narsil-cms/components/dialog";
import {
  FormCountry,
  FormLanguage,
  FormProvider,
  FormRenderer,
  FormRoot,
} from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionRoot } from "@narsil-cms/components/section";
import { StatusItem, StatusRoot } from "@narsil-cms/components/status";
import { TabsContent, TabsList, TabsRoot, TabsTrigger } from "@narsil-cms/components/tabs";
import { useMinLg } from "@narsil-cms/hooks/use-breakpoints";
import { cn } from "@narsil-cms/lib/utils";
import { useModalStore, type ModalType } from "@narsil-cms/stores/modal-store";
import type { FormType, Revision, SelectOption, TemplateSection } from "@narsil-cms/types";
import { isEmpty } from "lodash";
import { Slot } from "radix-ui";
import { useEffect, useState } from "react";

type FormProps = FormType & {
  countries?: SelectOption[];
  data: Record<string, unknown>;
  modal?: ModalType;
  revisions?: Revision[];
};

function ResourceForm({
  action,
  autoSave,
  countries,
  data,
  defaultLanguage,
  id,
  languageOptions,
  layout,
  method,
  modal,
  revisions,
  routes,
  submitLabel,
}: FormProps) {
  const { trans } = useLocalization();
  const { closeTopModal } = useModalStore();

  const minLg = useMinLg();

  const { sidebar, tabs } = layout.reduce(
    (acc, element) => {
      if (!("elements" in element)) {
        return acc;
      }

      switch (element.handle) {
        case "sidebar":
          acc.sidebar = element;
          break;
        default:
          acc.tabs.push(element);
          break;
      }

      return acc;
    },
    {
      sidebar: undefined as TemplateSection | undefined,
      tabs: [] as TemplateSection[],
    },
  );

  const [value, setValue] = useState(tabs[0].handle);

  const sidebarContent = sidebar ? <FormRenderer {...sidebar} /> : null;

  const tabsList =
    tabs.length > 1 ? (
      <TabsList className="w-full">
        {tabs.map((tab, index) => {
          return (
            <TabsTrigger value={tab.handle} key={index}>
              {tab.name}
            </TabsTrigger>
          );
        })}
      </TabsList>
    ) : null;

  const tabsContent = tabs.map((tab, index) => {
    return (
      <TabsContent className="gap-8" value={tab.handle} key={index}>
        <FormRenderer {...tab} />
      </TabsContent>
    );
  });

  useEffect(() => {
    const handles = tabs.map((tab) => tab.handle);

    if (!handles.includes(value)) {
      setValue(tabs[0]?.handle);
    }
  }, [minLg, tabs, value]);

  return (
    <FormProvider
      id={modal ? `${id}_${modal.id}` : id}
      action={action}
      elements={layout}
      defaultLanguage={defaultLanguage}
      languageOptions={languageOptions}
      method={method}
      initialValues={{
        _back: modal !== undefined,
        ...data,
      }}
      render={({ formLanguage, setFormLanguage }) => {
        return (
          <FormRoot
            className="flex max-h-full min-h-full animate-in overflow-hidden fade-in-0"
            autoSave={autoSave}
            options={{
              onSuccess: (response) => {
                if (modal) {
                  modal.linkProps?.onSuccess?.(response);

                  closeTopModal();
                }
              },
            }}
          >
            {modal ? (
              <>
                <DialogBody>
                  <TabsRoot
                    defaultValue={tabs[0].handle}
                    value={value}
                    onValueChange={setValue}
                    className="gap-4 lg:col-span-8"
                  >
                    {tabsList}
                    {tabsContent}
                  </TabsRoot>
                </DialogBody>
                <DialogFooter className="h-fit border-t">
                  <DialogClose asChild={true}>
                    <Button variant="ghost">{trans("ui.cancel")}</Button>
                  </DialogClose>
                  <Button form={`${id}_${modal.id}`} type="submit">
                    {isEmpty(submitLabel) ? trans("ui.save") : submitLabel}
                  </Button>
                </DialogFooter>
              </>
            ) : (
              <>
                <SectionRoot className="max-h-full min-h-full flex-3 overflow-y-auto">
                  <SectionContent>
                    <TabsRoot defaultValue={tabs[0].handle} value={value} onValueChange={setValue}>
                      {tabsList ? (
                        <Slot.Root className="flex items-center border-b px-4">
                          {tabsList}
                        </Slot.Root>
                      ) : null}
                      {tabsContent}
                    </TabsRoot>
                  </SectionContent>
                </SectionRoot>
                <SectionRoot className="max-h-full min-h-full flex-1 overflow-y-auto border-l">
                  <SectionContent className="flex flex-col">
                    <div className="flex h-13 flex-row-reverse items-center justify-between gap-2 border-b px-4 py-2">
                      <SaveButton
                        routes={routes}
                        submitLabel={isEmpty(submitLabel) ? trans("ui.save") : submitLabel}
                      />
                      {revisions ? (
                        <StatusRoot
                          className={cn(
                            "w-6",
                            "hover:w-10",
                            "transition-[width] delay-100 duration-300",
                          )}
                        >
                          {data.has_published_revision ? (
                            <StatusItem
                              className="bg-green-500"
                              tooltip={trans("revisions.published")}
                            />
                          ) : null}
                          {!data.published ? (
                            <StatusItem
                              className="bg-amber-500"
                              tooltip={trans("revisions.saved")}
                            />
                          ) : null}
                          {data.has_draft ? (
                            <StatusItem className="bg-red-500" tooltip={trans("revisions.draft")} />
                          ) : null}
                        </StatusRoot>
                      ) : null}
                    </div>
                    <div className="flex flex-col items-start gap-2 border-b p-4">
                      {data?.created_at ? (
                        <div className="flex items-center gap-1 self-start">
                          <span className="text-foreground/70">{trans("datetime.created")}</span>
                          <span className="font-medium">{data.created_at}</span>
                          {data?.creator ? (
                            <>
                              <span className="text-foreground/70">{trans("datetime.by")}</span>
                              <span className="font-medium">{data.creator.full_name}</span>
                            </>
                          ) : null}
                        </div>
                      ) : null}
                      {data?.updated_at ? (
                        <div className="flex items-center gap-1">
                          <span className="text-foreground/70">{trans("datetime.updated")}</span>
                          <span className="font-medium">{data.updated_at}</span>
                          {data?.editor || data?.creator ? (
                            <>
                              <span className="text-foreground/70">{trans("datetime.by")}</span>
                              <span className="font-medium">
                                {data.editor?.full_name ?? data.creator?.full_name}
                              </span>
                            </>
                          ) : null}
                        </div>
                      ) : null}
                      {revisions ? <RevisionSelect revisions={revisions} /> : null}
                    </div>
                    {countries ? (
                      <div className="flex flex-col gap-1 border-b p-2">
                        <div className="flex items-center justify-start gap-2 pl-2">
                          <Icon className="size-4" name="globe" />
                          <Heading level="h3" variant="discreet">
                            {trans("ui.countries")}
                          </Heading>
                        </div>
                        <FormCountry className="pr-2" countries={countries} />
                      </div>
                    ) : null}
                    {languageOptions?.length > 0 ? (
                      <div className="flex flex-col gap-1 border-b p-2">
                        <div className="flex items-center justify-start gap-2 pl-2">
                          <Icon className="size-4" name="globe" />
                          <Heading level="h3" variant="discreet">
                            {trans("ui.translations")}
                          </Heading>
                        </div>
                        <FormLanguage
                          className="pr-2"
                          value={formLanguage}
                          onValueChange={setFormLanguage}
                        />
                      </div>
                    ) : null}

                    <div className="flex flex-col gap-y-4 lg:col-span-4">
                      {sidebarContent ? (
                        <Card
                          contentProps={{
                            className: "grid-cols-12",
                          }}
                        >
                          {sidebarContent}
                        </Card>
                      ) : null}
                    </div>
                  </SectionContent>
                </SectionRoot>
              </>
            )}
          </FormRoot>
        );
      }}
      key={modal ? `${id}_${modal.id}` : id}
    />
  );
}

export default ResourceForm;

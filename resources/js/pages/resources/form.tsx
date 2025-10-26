import { Button, Card, Heading, RevisionSelect, SaveButton } from "@narsil-cms/blocks";
import { DialogBody, DialogClose, DialogFooter } from "@narsil-cms/components/dialog";
import { FormLanguage, FormProvider, FormRenderer, FormRoot } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import { TabsContent, TabsList, TabsRoot, TabsTrigger } from "@narsil-cms/components/tabs";
import { useMinLg } from "@narsil-cms/hooks/use-breakpoints";
import { useModalStore, type ModalType } from "@narsil-cms/stores/modal-store";
import type { FormType, Revision, TemplateSection } from "@narsil-cms/types";
import { isEmpty } from "lodash";
import { useEffect, useState } from "react";

type FormProps = FormType & {
  data: Record<string, unknown>;
  modal?: ModalType;
  revisions?: Revision[];
};

function ResourceForm({
  action,
  autoSave,
  data,
  id,
  languageOptions,
  layout,
  method,
  modal,
  revisions,
  routes,
  submitLabel,
  title,
}: FormProps) {
  const { trans } = useLocalization();
  const { closeTopModal } = useModalStore();

  const minLg = useMinLg();

  const { information, sidebar, tabs } = layout.reduce(
    (acc, element) => {
      if (!("elements" in element)) {
        return acc;
      }

      switch (element.handle) {
        case "information":
          if (data?.id) {
            if (modal || !minLg) {
              acc.tabs.push(element);
            } else {
              acc.information = element;
            }
          }
          break;
        case "sidebar":
          if (!minLg) {
            acc.tabs.push(element);
          } else {
            acc.sidebar = element;
          }
          break;
        default:
          acc.tabs.push(element);
          break;
      }

      return acc;
    },
    {
      information: undefined as TemplateSection | undefined,
      sidebar: undefined as TemplateSection | undefined,
      tabs: [] as TemplateSection[],
    },
  );

  const [value, setValue] = useState(tabs[0].handle);

  const informationContent = information ? <FormRenderer {...information} /> : null;

  const sidebarContent = sidebar ? <FormRenderer {...sidebar} /> : null;

  const tabsContent = (
    <TabsRoot
      defaultValue={tabs[0].handle}
      value={value}
      onValueChange={setValue}
      className="gap-4 lg:col-span-8"
    >
      {tabs.length > 1 ? (
        <TabsList className="w-full">
          {tabs.map((tab, index) => {
            return (
              <TabsTrigger value={tab.handle} key={index}>
                {tab.name}
              </TabsTrigger>
            );
          })}
        </TabsList>
      ) : null}
      {tabs.map((tab, index) => {
        return (
          <TabsContent className="p-0" value={tab.handle} key={index}>
            <Card className="overflow-hidden" contentProps={{ className: "grid-cols-12 gap-4" }}>
              <FormRenderer {...tab} />
            </Card>
          </TabsContent>
        );
      })}
    </TabsRoot>
  );

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
      method={method}
      initialValues={{
        _back: modal !== undefined,
        ...data,
      }}
      languageOptions={languageOptions}
      render={({ language, setLanguage }) => {
        return (
          <FormRoot
            className="animate-in overflow-hidden fade-in-0"
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
                <DialogBody>{tabsContent}</DialogBody>
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
              <SectionRoot className="px-4 py-2">
                <SectionHeader className="h-13 border-b pb-2!">
                  <div className="flex items-end gap-2">
                    <Heading level="h1" variant="h4">
                      {title}
                    </Heading>
                    <FormLanguage
                      showIcon={false}
                      triggerProps={{
                        className: "bg-secondary",
                        size: "sm",
                      }}
                      value={language}
                      onValueChange={setLanguage}
                    />
                    {revisions ? <RevisionSelect revisions={revisions} /> : null}
                  </div>
                  <SaveButton
                    routes={routes}
                    submitLabel={isEmpty(submitLabel) ? trans("ui.save") : submitLabel}
                  />
                </SectionHeader>
                <SectionContent className="grid gap-4 lg:grid-cols-12">
                  {tabsContent}
                  {minLg && (sidebarContent || informationContent) ? (
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
                      {informationContent ? (
                        <Card
                          contentProps={{
                            className: "grid-cols-12 justify-between",
                          }}
                        >
                          {informationContent}
                        </Card>
                      ) : null}
                    </div>
                  ) : null}
                </SectionContent>
              </SectionRoot>
            )}
          </FormRoot>
        );
      }}
      key={modal ? `${id}_${modal.id}` : id}
    />
  );
}

export default ResourceForm;

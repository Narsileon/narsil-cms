import { Button } from "@narsil-cms/components/button";
import { Card, CardContent } from "@narsil-cms/components/card";
import { ScrollArea } from "@narsil-cms/components/scroll-area";
import { isEmpty } from "lodash";
import { SaveButton } from "@narsil-cms/blocks";
import { useEffect, useState } from "react";
import { useLabels } from "@narsil-cms/components/labels";
import { useMinLg } from "@narsil-cms/hooks/use-breakpoints";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import {
  DialogBody,
  DialogClose,
  DialogFooter,
} from "@narsil-cms/components/dialog";
import {
  FormProvider,
  FormRoot,
  FormSubmit,
  FormFieldRenderer,
} from "@narsil-cms/components/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/section";
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from "@narsil-cms/components/tabs";
import type { Block, FormType } from "@narsil-cms/types/forms";
import type { ModalState } from "@narsil-cms/stores/modal-store";

type FormProps = FormType & {
  data: any;
  modal?: ModalState;
};

function ResourceForm({
  data,
  form,
  id,
  method,
  modal,
  submitLabel,
  title,
  url,
}: FormProps) {
  const { trans } = useLabels();
  const { closeTopModal } = useModalStore();

  const minLg = useMinLg();

  const { information, sidebar, tabs } = form.reduce(
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
      information: undefined as Block | undefined,
      sidebar: undefined as Block | undefined,
      tabs: [] as Block[],
    },
  );

  const [value, setValue] = useState(tabs[0].handle);

  const informationContent = information?.elements.map((element, index) => {
    return (
      <FormFieldRenderer
        conditions={element.conditions}
        element={element.element}
        key={index}
      />
    );
  });

  const sidebarContent = sidebar?.elements.map((element, index) => {
    return (
      <FormFieldRenderer
        conditions={element.conditions}
        element={element.element}
        key={index}
      />
    );
  });

  const tabsContent = (
    <Tabs
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
            <Card className="overflow-hidden">
              <CardContent>
                {tab.elements.map((element, index) => {
                  return (
                    <FormFieldRenderer
                      conditions={element.conditions}
                      element={element.element}
                      handle={element.handle}
                      name={element.name}
                      key={index}
                    />
                  );
                })}
              </CardContent>
            </Card>
          </TabsContent>
        );
      })}
    </Tabs>
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
      action={url}
      elements={form}
      method={method}
      initialValues={{
        _back: modal,
        ...data,
      }}
      render={() => (
        <FormRoot
          className="overflow-hidden"
          options={{
            onSuccess: (response) => {
              if (modal) {
                modal.options?.onSuccess?.(response);

                closeTopModal();
              }
            },
          }}
        >
          {modal ? (
            <ScrollArea>
              <DialogBody>{tabsContent}</DialogBody>
              <DialogFooter className="h-fit border-t">
                <DialogClose asChild={true}>
                  <Button variant="ghost">{trans("ui.cancel")}</Button>
                </DialogClose>
                <FormSubmit className="place-self-auto">
                  {isEmpty(submitLabel) ? trans("ui.save") : submitLabel}
                </FormSubmit>
              </DialogFooter>
            </ScrollArea>
          ) : (
            <Section className="p-4">
              <SectionHeader>
                <SectionTitle level="h1" variant="h4">
                  {title}
                </SectionTitle>
                <SaveButton
                  submitLabel={
                    isEmpty(submitLabel) ? trans("ui.save") : submitLabel
                  }
                />
              </SectionHeader>
              <SectionContent className="grid gap-4 lg:grid-cols-12">
                {tabsContent}
                {minLg && (sidebarContent || informationContent) ? (
                  <div className="flex flex-col gap-y-4 lg:col-span-4">
                    {sidebarContent ? (
                      <Card>
                        <CardContent className="grid-cols-12">
                          {sidebarContent}
                        </CardContent>
                      </Card>
                    ) : null}
                    {informationContent ? (
                      <Card>
                        <CardContent className="grid-cols-12 justify-between text-sm">
                          {informationContent}
                        </CardContent>
                      </Card>
                    ) : null}
                  </div>
                ) : null}
              </SectionContent>
            </Section>
          )}
        </FormRoot>
      )}
    />
  );
}

export default ResourceForm;

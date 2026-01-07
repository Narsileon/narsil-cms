import { Button } from "@narsil-cms/blocks/button";
import { Heading } from "@narsil-cms/blocks/heading";
import { RevisionSelect } from "@narsil-cms/blocks/revision-select";
import { Status } from "@narsil-cms/blocks/status";
import { DialogBody, DialogClose, DialogFooter } from "@narsil-cms/components/dialog";
import {
  FormCountry,
  FormElement,
  FormLanguage,
  FormMenu,
  FormProvider,
  FormRoot,
  FormSave,
  FormTimestamp,
} from "@narsil-cms/components/form";
import FormPublish from "@narsil-cms/components/form/form-publish";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionRoot } from "@narsil-cms/components/section";
import { TabsContent, TabsList, TabsRoot, TabsTrigger } from "@narsil-cms/components/tabs";
import { useMinLg } from "@narsil-cms/hooks/use-breakpoints";
import { cn } from "@narsil-cms/lib/utils";
import { useModalStore, type ModalType } from "@narsil-cms/stores/modal-store";
import type { FormType, Revision, SelectOption, TemplateTab, User } from "@narsil-cms/types";
import { isEmpty } from "lodash-es";
import { useEffect, useState } from "react";

type FormProps = {
  countries?: SelectOption[];
  data?: {
    created_at?: string;
    creator?: User;
    editor?: User;
    updated_at?: string;
    [key: string]: unknown;
  };
  form: FormType;
  modal?: ModalType;
  publish?: FormType;
  revisions?: Revision[];
};

function ResourceForm({ countries, data, form, modal, publish, revisions }: FormProps) {
  const { trans } = useLocalization();
  const { closeTopModal } = useModalStore();

  const minLg = useMinLg();

  const {
    action,
    autoSave,
    defaultLanguage,
    id,
    languageOptions,
    method,
    routes,
    submitLabel,
    tabs,
  } = form;

  const { sidebar, standardTabs } = tabs.reduce(
    (acc, element) => {
      if (!("elements" in element)) {
        return acc;
      }

      switch (element.handle) {
        case "sidebar":
          acc.sidebar = element;
          break;
        default:
          acc.standardTabs.push(element);
          break;
      }

      return acc;
    },
    {
      sidebar: undefined as TemplateTab | undefined,
      standardTabs: [] as TemplateTab[],
    },
  );

  const [value, setValue] = useState(standardTabs[0].handle);

  const sidebarContent = sidebar ? (
    <>
      {sidebar.elements?.map((element, index) => {
        return <FormElement {...element} key={index} />;
      })}
    </>
  ) : null;

  const tabsList =
    standardTabs.length > 1 ? (
      <TabsList className="flex w-full items-center border-b px-4">
        {standardTabs.map((tab, index) => {
          return (
            <TabsTrigger value={tab.handle} key={index}>
              {tab.label}
            </TabsTrigger>
          );
        })}
      </TabsList>
    ) : null;

  const tabsContent = standardTabs.map((tab, index) => {
    return (
      <TabsContent
        className="grid w-full max-w-5xl grid-cols-12 gap-x-4 gap-y-8 place-self-center"
        value={tab.handle}
        key={index}
      >
        {tab.elements?.map((element, index) => {
          return <FormElement {...element} key={index} />;
        })}
      </TabsContent>
    );
  });

  useEffect(() => {
    const handles = standardTabs.map((tab) => tab.handle);

    if (!handles.includes(value)) {
      setValue(standardTabs[0]?.handle);
    }
  }, [minLg, standardTabs, value]);

  return (
    <FormProvider
      id={modal ? `${id}_${modal.id}` : id}
      action={action}
      elements={tabs}
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
            className="relative w-full animate-in grid-cols-12 items-center fade-in-0 md:h-full md:max-h-full md:min-h-full md:overflow-hidden"
            autoSave={autoSave}
            options={{
              preserveState: true,
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
                <DialogBody className="col-span-full h-full p-0">
                  <TabsRoot
                    defaultValue={standardTabs[0].handle}
                    value={value}
                    onValueChange={setValue}
                  >
                    {tabsList}
                    {tabsContent}
                  </TabsRoot>
                </DialogBody>
                <DialogFooter className="col-span-full h-fit border-t">
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
                <SectionRoot
                  className={cn(
                    "col-span-12 h-full max-h-full min-h-full flex-3",
                    "md:col-span-7 md:overflow-y-auto",
                    "lg:col-span-8",
                    "2xl:col-span-9",
                  )}
                >
                  <SectionContent>
                    <TabsRoot
                      defaultValue={standardTabs[0].handle}
                      value={value}
                      onValueChange={setValue}
                    >
                      {tabsList}
                      {tabsContent}
                    </TabsRoot>
                  </SectionContent>
                </SectionRoot>
                <SectionRoot
                  className={cn(
                    "col-span-12 h-full max-h-full min-h-full flex-1 overflow-y-auto border-t",
                    "md:col-span-5 md:border-t-0 md:border-l",
                    "lg:col-span-4",
                    "2xl:col-span-3",
                  )}
                >
                  <SectionContent className="flex flex-col">
                    <div className="flex h-13 flex-row-reverse items-center justify-between gap-2 border-b px-4 py-2">
                      <div className="flex items-center gap-2">
                        <FormSave
                          routes={routes}
                          submitLabel={isEmpty(submitLabel) ? trans("ui.save") : submitLabel}
                        />
                        {routes?.destroy && method !== "post" ? <FormMenu routes={routes} /> : null}
                      </div>
                      {revisions ? (
                        <Status
                          className={cn(
                            "w-6",
                            "hover:w-10",
                            "transition-[width] delay-100 duration-300",
                          )}
                          draft={!!data?.has_draft}
                          published={!!data?.has_published_revision}
                          saved={!!data?.has_new_revision}
                        />
                      ) : null}
                    </div>
                    {publish ? <FormPublish form={publish} /> : null}
                    {data?.created_at ? (
                      <div className="grid items-start gap-4 border-b p-4">
                        {data?.created_at ? (
                          <div className="grid gap-2">
                            {data?.created_at ? (
                              <FormTimestamp
                                label={trans("datetime.created")}
                                date={data.created_at}
                                name={data.creator?.full_name}
                              />
                            ) : null}
                            {data?.updated_at ? (
                              <FormTimestamp
                                label={trans("datetime.updated")}
                                date={data.updated_at}
                                name={data.editor?.full_name ?? data.creator?.full_name}
                              />
                            ) : null}
                          </div>
                        ) : null}
                        {revisions ? <RevisionSelect revisions={revisions} /> : null}
                      </div>
                    ) : null}
                    {countries ? (
                      <div className="grid gap-1 border-b p-2">
                        <div className="flex items-center justify-start gap-2 pl-2.5">
                          <Icon className="size-4" name="globe" />
                          <Heading level="h3" variant="discreet">
                            {trans("ui.countries")}
                          </Heading>
                        </div>
                        <FormCountry className="pr-2" countries={countries} />
                      </div>
                    ) : null}
                    {languageOptions?.length > 0 ? (
                      <div className="grid gap-1 border-b p-2">
                        <div className="flex items-center justify-start gap-2 pl-2.5">
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

                    <div className="grid gap-y-4 p-4 lg:col-span-4">{sidebarContent}</div>
                  </SectionContent>
                </SectionRoot>
              </>
            )}
          </FormRoot>
        );
      }}
    />
  );
}

export default ResourceForm;

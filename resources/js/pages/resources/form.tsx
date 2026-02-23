import { RevisionSelect } from "@narsil-cms/blocks/revision-select";
import { Status } from "@narsil-cms/blocks/status";
import { FormCountry } from "@narsil-cms/components/form";
import FormPublish from "@narsil-cms/components/form/form-publish";
import registry from "@narsil-cms/components/form/inputs";
import type { Revision, User } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import { DialogBody, DialogClose, DialogFooter } from "@narsil-ui/components/dialog";
import {
  FormBlame,
  FormElement,
  FormLanguage,
  FormMenu,
  FormProvider,
  FormRoot,
  FormSave,
  FormTabs,
} from "@narsil-ui/components/form";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { SectionContent, SectionRoot } from "@narsil-ui/components/section";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import { useModalStore, type ModalData } from "@narsil-ui/stores/modal-store";
import type { FormData, FormStepData, OptionData } from "@narsil-ui/types";
import { isEmpty } from "lodash-es";

type FormProps = {
  countries?: OptionData[];
  data?: {
    created_at?: string;
    creator?: User;
    editor?: User;
    updated_at?: string;
    [key: string]: unknown;
  };
  form: FormData;
  modal?: ModalData;
  publish?: FormData;
  revisions?: Revision[];
};

function ResourceForm({ countries, data, form, modal, publish, revisions }: FormProps) {
  const { trans } = useTranslator();
  const { closeTopModal } = useModalStore();

  const { action, autoSave, defaultLanguage, id, languages, method, routes, submitLabel, steps } =
    form;

  const { sidebar, standardTabs } = steps.reduce(
    (acc, element) => {
      if (!("elements" in element)) {
        return acc;
      }

      switch (element.id) {
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
      sidebar: undefined as FormStepData | undefined,
      standardTabs: [] as FormStepData[],
    },
  );

  const sidebarContent = sidebar ? (
    <>
      {sidebar.elements?.map((element, index) => {
        return <FormElement {...element} key={index} />;
      })}
    </>
  ) : null;

  return (
    <FormProvider
      id={modal ? `${id}_${modal.id}` : id}
      action={action}
      steps={steps}
      defaultLanguage={defaultLanguage}
      languages={languages}
      method={method}
      registry={registry}
      initialData={{
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
                  modal.link?.onSuccess?.(response);

                  closeTopModal();
                }
              },
            }}
          >
            {modal ? (
              <>
                <DialogBody className="col-span-full h-full p-0">
                  <FormTabs steps={standardTabs} />
                </DialogBody>
                <DialogFooter className="col-span-full h-fit border-t">
                  <DialogClose render={<Button variant="ghost">{trans("ui.cancel")}</Button>} />
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
                    <FormTabs steps={standardTabs} />
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
                              <FormBlame
                                label={trans("blame.created")}
                                date={data.created_at}
                                name={data.creator?.full_name}
                              />
                            ) : null}
                            {data?.updated_at ? (
                              <FormBlame
                                label={trans("blame.updated")}
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
                    {languages?.length > 0 ? (
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

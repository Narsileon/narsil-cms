import { RevisionSelect } from "@narsil-cms/blocks/revision-select";
import { Status } from "@narsil-cms/blocks/status";
import { FormCountry } from "@narsil-cms/components/form";
import FormPublish from "@narsil-cms/components/form/form-publish";
import type { Revision } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import { DialogClose, DialogFooter } from "@narsil-ui/components/dialog";
import {
  FormBlame,
  FormElement,
  FormLanguage,
  FormMenu,
  FormProvider,
  FormRoot,
  FormSave,
  FormTabs,
  type FormBlameData,
} from "@narsil-ui/components/form";
import { SectionContent, SectionRoot } from "@narsil-ui/components/section";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import { useModalStore, type ModalData } from "@narsil-ui/stores/modal-store";
import type { FormData, FormStepData, OptionData } from "@narsil-ui/types";
import { isEmpty } from "lodash-es";

type FormProps = {
  countries?: OptionData[];
  data?: FormBlameData & {
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

  const {
    action,
    autoSave,
    defaultLanguage,
    id,
    languages,
    method,
    options,
    routes,
    submitLabel,
    steps,
  } = form;

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
      defaultLanguage={defaultLanguage}
      languages={languages}
      method={method}
      options={options}
      steps={steps}
      initialData={{
        _back: modal !== undefined,
        ...data,
      }}
      render={({ formLanguage, setFormLanguage }) => {
        return (
          <>
            <FormRoot
              className={cn(
                "relative w-full animate-in grid-cols-12 fade-in-0 md:overflow-hidden",
                modal ? "grow" : "items-center md:h-full md:max-h-full md:min-h-full",
              )}
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

                  <div className="grid items-start gap-4 border-b p-4">
                    <FormBlame
                      data={{
                        created_at: data?.created_at,
                        updated_at: data?.updated_at,
                        creator: data?.creator,
                        editor: data?.editor,
                      }}
                    />
                    {revisions ? <RevisionSelect revisions={revisions} /> : null}
                  </div>
                  {countries ? <FormCountry countries={countries} /> : null}
                  {languages?.length > 0 ? (
                    <FormLanguage value={formLanguage} onValueChange={setFormLanguage} />
                  ) : null}

                  <div className="grid gap-y-4 p-4 lg:col-span-4">{sidebarContent}</div>
                </SectionContent>
              </SectionRoot>
            </FormRoot>
            {modal && (
              <DialogFooter className="col-span-full h-fit border-t">
                <DialogClose render={<Button variant="ghost">{trans("ui.cancel")}</Button>} />
                <Button form={`${id}_${modal.id}`} type="submit">
                  {isEmpty(submitLabel) ? trans("ui.save") : submitLabel}
                </Button>
              </DialogFooter>
            )}
          </>
        );
      }}
    />
  );
}

export default ResourceForm;

import { Button } from "@narsil-ui/components/button";
import {
  FormBlock,
  FormElement,
  FormLanguage,
  FormProvider,
  FormRoot,
  FormTabs,
} from "@narsil-ui/components/form";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { Spinner } from "@narsil-ui/components/spinner";
import { useTranslator } from "@narsil-ui/components/translator";
import type { FormStepData } from "@narsil-ui/types";
import { useEffect } from "react";
import { useLiveEditor, useLiveEditorState } from "../live-editor-context";

type FormSectionsProps = {
  steps: FormStepData[];
};

function FormSections({ steps }: FormSectionsProps) {
  return (
    <div className="grid gap-6">
      {steps.map((step, stepIndex) => {
        return (
          <section className="grid gap-4 border-b pb-6 last:border-b-0" key={step.id ?? stepIndex}>
            {step.label ? <Heading level="h3">{step.label}</Heading> : null}
            <div className="grid gap-4">
              {step.elements.map((element, elementIndex) => {
                return (
                  <FormElement
                    {...element}
                    render={(fieldset) => {
                      return <FormBlock baseId={element.id as string} fieldset={fieldset} />;
                    }}
                    key={element.id ?? elementIndex}
                  />
                );
              })}
            </div>
          </section>
        );
      })}
    </div>
  );
}

function NodeInspector() {
  const { addTranslations, trans } = useTranslator();

  const editor = useLiveEditor();
  const { inspector, loadingInspector, saving } = useLiveEditorState();

  const translations = inspector?.translations;

  // Inputs register their labels server side, and the inspector is fetched after
  // the page rendered, so those labels travel with it. addTranslations is left
  // out of the dependencies because the translator recreates it every render.
  useEffect(() => {
    if (translations) {
      addTranslations(translations);
    }
  }, [translations]);

  if (loadingInspector) {
    return (
      <div className="flex h-full items-center justify-center p-4">
        <Spinner />
      </div>
    );
  }

  if (!inspector) {
    const { pageData, pageForm, sitePageTitle } = editor.bootstrap;

    return (
      <FormProvider
        id={`live-editor-page-${editor.bootstrap.sitePageId}`}
        action={pageForm.action}
        defaultLanguage={pageForm.defaultLanguage}
        initialData={pageData}
        languages={pageForm.languages}
        method={pageForm.method}
        options={pageForm.options}
        steps={pageForm.steps}
        render={({ formLanguage, setFormLanguage }) => {
          return (
            <FormRoot
              className="h-full min-h-0 overflow-hidden"
              id={`live-editor-page-${editor.bootstrap.sitePageId}`}
              action={pageForm.action}
              method={pageForm.method}
              options={{ preserveState: true }}
            >
              <div className="flex h-full min-h-0 flex-col overflow-hidden">
                <div className="flex h-13 shrink-0 items-center justify-between gap-2 border-b px-4">
                  <Heading className="truncate" level="h2">
                    {sitePageTitle ?? trans("live-editor.pages.title")}
                  </Heading>
                  <Button form={`live-editor-page-${editor.bootstrap.sitePageId}`} size="sm" type="submit">
                    <Icon name="save" />
                    {trans("ui.save")}
                  </Button>
                </div>
                {pageForm.languages?.length > 1 ? (
                  <FormLanguage value={formLanguage} onValueChange={setFormLanguage} />
                ) : null}
                <div className="min-w-0 grow overflow-x-hidden overflow-y-auto p-4">
                  <FormSections steps={pageForm.steps} />
                </div>
              </div>
            </FormRoot>
          );
        }}
      />
    );
  }

  const { data, form, label, nodeUuid } = inspector;

  return (
    <FormProvider
      // Remounts the form state when another block is selected.
      key={nodeUuid}
      id={`live-editor-${nodeUuid}`}
      action={form.action}
      defaultLanguage={form.defaultLanguage}
      initialData={data}
      languages={form.languages}
      method={form.method}
      options={form.options}
      steps={form.steps}
      render={({ data: formData, formLanguage, setFormLanguage }) => {
        return (
          <div className="flex h-full flex-col overflow-hidden">
            <div className="flex h-13 shrink-0 items-center justify-between gap-2 border-b px-4">
              <Heading className="truncate" level="h2">
                {label}
              </Heading>
              <Button
                disabled={saving}
                size="sm"
                onClick={() => editor.saveNode(nodeUuid, formData ?? {})}
              >
                {saving ? <Spinner /> : <Icon name="save" />}
                {trans("ui.save")}
              </Button>
            </div>
            {form.languages?.length > 1 ? (
              <FormLanguage value={formLanguage} onValueChange={setFormLanguage} />
            ) : null}
            {/* The inspector is far narrower than a regular form page, so grid
                items have to be allowed to shrink below their content width. */}
            <div className="min-w-0 grow overflow-x-hidden overflow-y-auto p-4 [&_[data-slot=collapsible-root]]:min-w-0 [&_[data-slot=field-root]]:min-w-0">
              <FormTabs steps={form.steps} />
            </div>
          </div>
        );
      }}
    />
  );
}

export default NodeInspector;

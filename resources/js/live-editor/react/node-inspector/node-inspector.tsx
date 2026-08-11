import { Button } from "@narsil-ui/components/button";
import {
  FormLanguage,
  FormProvider,
  FormTabs,
} from "@narsil-ui/components/form";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { Spinner } from "@narsil-ui/components/spinner";
import { useTranslator } from "@narsil-ui/components/translator";
import { useEffect } from "react";
import { useLiveEditor, useLiveEditorState } from "../live-editor-context";

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
    return (
      <p className="p-4 text-sm text-muted-foreground">
        {trans("live_editor.inspector.empty")}
      </p>
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
              <FormLanguage
                value={formLanguage}
                onValueChange={setFormLanguage}
              />
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

import {
  FormMenu,
  FormProvider,
  FormRenderer,
  FormRoot,
  FormSave,
} from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionRoot } from "@narsil-cms/components/section";
import { cn } from "@narsil-cms/lib/utils";
import type { FormType } from "@narsil-cms/types";
import { isEmpty } from "lodash";

type SettingsProps = {
  data?: Record<string, unknown>;
  form: FormType;
};

function Settings({ data, form }: SettingsProps) {
  const { trans } = useLocalization();

  const { action, id, layout, method, routes, submitLabel } = form;

  return (
    <FormProvider
      id={id}
      action={action}
      elements={layout}
      method={method}
      initialValues={{
        ...data,
      }}
      render={() => {
        return (
          <FormRoot className="relative w-full animate-in grid-cols-12 items-center fade-in-0 md:h-full md:max-h-full md:min-h-full md:overflow-hidden">
            <SectionRoot
              className={cn(
                "col-span-12 h-full max-h-full min-h-full flex-3 items-center",
                "md:col-span-7 md:overflow-y-auto",
                "lg:col-span-8",
                "2xl:col-span-9",
              )}
            >
              <SectionContent className="flex w-full max-w-5xl flex-col justify-center p-4">
                {layout.map((element) => {
                  return <FormRenderer {...element} />;
                })}
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
                </div>
              </SectionContent>
            </SectionRoot>
          </FormRoot>
        );
      }}
    />
  );
}

export default Settings;

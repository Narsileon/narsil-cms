import { router } from "@inertiajs/react";
import { route } from "ziggy-js";

import { Heading } from "@narsil-cms/blocks";
import {
  FormRenderer,
  FormProvider,
  FormRoot,
} from "@narsil-cms/components/form";
import { useLabels } from "@narsil-cms/components/labels";
import {
  SectionContent,
  SectionHeader,
  SectionRoot,
} from "@narsil-cms/components/section";
import { useLocale } from "@narsil-cms/hooks/use-props";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import { useThemeStore, type Theme } from "@narsil-cms/stores/theme-store";
import { type FormType } from "@narsil-cms/types";

type ConfigurationFormProps = {
  form: FormType;
};

function ConfigurationForm({ form }: ConfigurationFormProps) {
  const { trans } = useLabels();
  const { locale } = useLocale();

  const { reloadTopModal } = useModalStore();

  const { color, setColor } = useColorStore();
  const { radius, setRadius } = useRadiusStore();
  const { theme, setTheme } = useThemeStore();

  function handleChange(id: string, value: number | string) {
    switch (id) {
      case "color":
        setColor(value as string);
        break;
      case "radius":
        setRadius(value as number);
        break;
      case "theme":
        setTheme(value as Theme);
        break;
      default:
        break;
    }

    const data = {
      [id]: value,
    };

    router.post(route("user-configuration.store"), data, {
      preserveState: false,
      onSuccess: () => {
        reloadTopModal();
      },
    });
  }

  return (
    <SectionRoot>
      <SectionHeader className="border-b">
        <Heading level="h2">{trans("ui.personalization")}</Heading>
      </SectionHeader>
      <SectionContent>
        <FormProvider
          id="user-personalization-form"
          action={form.action}
          elements={form.layout}
          method={form.method}
          initialValues={{
            color: color,
            locale: locale,
            radius: radius,
            theme: theme,
          }}
          render={() => (
            <FormRoot className="gap-4">
              {form.layout.map((element, index) => {
                return (
                  <FormRenderer
                    {...element}
                    className="grid grid-cols-2"
                    onChange={(value) => handleChange(element.handle, value)}
                    key={index}
                  />
                );
              })}
            </FormRoot>
          )}
        />
      </SectionContent>
    </SectionRoot>
  );
}

export default ConfigurationForm;

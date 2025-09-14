import { router } from "@inertiajs/react";
import { route } from "ziggy-js";

import {
  FormFieldRenderer,
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
import { getSelectOption } from "@narsil-cms/lib/utils";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import { useThemeStore, type Theme } from "@narsil-cms/stores/theme-store";
import { type FormType } from "@narsil-cms/types";
import { HeadingRoot } from "@narsil-cms/components/heading";

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

  function handleChange(id: string, value: unknown) {
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

    router.post(
      route("user-configuration.store"),
      {
        [id]: value,
      },
      {
        preserveState: false,
        onSuccess: () => {
          reloadTopModal();
        },
      },
    );
  }

  return (
    <SectionRoot>
      <SectionHeader className="border-b">
        <HeadingRoot level="h2">{trans("ui.personalization")}</HeadingRoot>
      </SectionHeader>
      <SectionContent>
        <FormProvider
          id="user-personalization-form"
          action={form.action}
          elements={form.form}
          method={form.method}
          initialValues={{
            color: color,
            locale: locale,
            radius: radius,
            theme: theme,
          }}
          render={() => (
            <FormRoot className="gap-4">
              {form.form.map((element, index) => {
                return (
                  <FormFieldRenderer
                    element={element}
                    className="grid grid-cols-2"
                    onChange={(value) => handleChange(element.handle, value)}
                    renderOption={
                      element.handle === "color"
                        ? (option) => {
                            return (
                              <>
                                <span
                                  className={`size-3 rounded-full bg-${getSelectOption(option, "value")}-500`}
                                />
                                {getSelectOption(option, "label")}
                              </>
                            );
                          }
                        : undefined
                    }
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

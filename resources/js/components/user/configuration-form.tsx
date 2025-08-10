import { getSelectOption } from "@narsil-cms/lib/utils";
import { route } from "ziggy-js";
import { router } from "@inertiajs/react";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useLocale } from "@narsil-cms/hooks/use-props";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import useColorStore from "@narsil-cms/stores/color-store";
import useRadiusStore from "@narsil-cms/stores/radius-store";
import useThemeStore from "@narsil-cms/stores/theme-store";
import {
  Form,
  FormFieldRenderer,
  FormProvider,
} from "@narsil-cms/components/ui/form";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/ui/section";
import type { FormType } from "@narsil-cms/types/forms";

type ConfigurationFormProps = {
  form: FormType;
};

function ConfigurationForm({ form }: ConfigurationFormProps) {
  const { getLabel } = useLabels();
  const { locale } = useLocale();

  const { reloadTopModal } = useModalStore();

  const { color, setColor } = useColorStore();
  const { radius, setRadius } = useRadiusStore();
  const { theme, setTheme } = useThemeStore();

  function handleChange(id: string, value: any) {
    switch (id) {
      case "color":
        setColor(value);
        break;
      case "radius":
        setRadius(value);
        break;
      case "theme":
        setTheme(value);
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
    <Section>
      <SectionHeader className="border-b">
        <SectionTitle level="h2">{getLabel("ui.personalization")}</SectionTitle>
      </SectionHeader>
      <SectionContent>
        <FormProvider
          id="user-personalization-form"
          elements={form.form}
          initialValues={{
            color: color,
            locale: locale,
            radius: radius,
            theme: theme,
          }}
          render={() => (
            <Form className="gap-4" method={form.method} url={form.url}>
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
            </Form>
          )}
        />
      </SectionContent>
    </Section>
  );
}

export default ConfigurationForm;

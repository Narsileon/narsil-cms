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
          fields={form.fields}
          initialValues={{
            color: color,
            locale: locale,
            radius: radius,
            theme: theme,
          }}
          render={() => (
            <Form className="gap-6" method={form.method} url={form.url}>
              {form.fields.map((field, index) => {
                return (
                  <FormFieldRenderer
                    field={field}
                    className="grid grid-cols-2"
                    onChange={(value) => handleChange(field.handle, value)}
                    renderOption={
                      field.handle === "color"
                        ? (option) => {
                            const color = getSelectOption(option, "bg-color");

                            return (
                              <>
                                <span
                                  className={`size-3 rounded-full ${color}`}
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

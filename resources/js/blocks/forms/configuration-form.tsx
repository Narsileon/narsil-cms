import { router } from "@inertiajs/react";
import { Heading } from "@narsil-cms/blocks";
import { FormProvider, FormRenderer, FormRoot } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-cms/components/section";
import { useLocale } from "@narsil-cms/hooks/use-props";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import type { FormType } from "@narsil-cms/types";
import { route } from "ziggy-js";

type ConfigurationFormProps = {
  form: FormType;
};

function ConfigurationForm({ form }: ConfigurationFormProps) {
  const { trans } = useLocalization();

  const { locale } = useLocale();

  const { color, setColor } = useColorStore();
  const { reloadTopModal } = useModalStore();
  const { radius, setRadius } = useRadiusStore();

  function handleChange(id: string, value: number | string) {
    switch (id) {
      case "color":
        setColor(value as string);
        return;
      case "radius":
        setRadius(value as number);
        return;
      default:
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
        break;
    }
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
          }}
          render={() => {
            return (
              <FormRoot className="gap-4">
                {form.layout.map((element, index) => {
                  return (
                    <FormRenderer
                      {...element}
                      className="grid grid-cols-2"
                      onChange={(value) => handleChange(element.handle, value as number | string)}
                      key={index}
                    />
                  );
                })}
              </FormRoot>
            );
          }}
        />
      </SectionContent>
    </SectionRoot>
  );
}

export default ConfigurationForm;

import { router } from "@inertiajs/react";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import { FormElement, FormProvider, FormRoot, registry } from "@narsil-ui/components/form";
import { Heading } from "@narsil-ui/components/heading";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-ui/components/section";
import { useTranslator } from "@narsil-ui/components/translator";
import type { FormData } from "@narsil-ui/types";
import { Fragment } from "react";
import { route } from "ziggy-js";

type ConfigurationFormProps = {
  form: FormData;
};

function ConfigurationForm({ form }: ConfigurationFormProps) {
  const { color, setColor } = useColorStore();
  const { reloadTopModal } = useModalStore();
  const { radius, setRadius } = useRadiusStore();
  const { locale, trans } = useTranslator();

  function handleChange(id: string, value: number | string) {
    console.log(id);
    switch (id) {
      case "color":
        setColor(value as string);
        return;
      case "radius":
        setRadius(value as number);
        return;
      default:
        router.post(
          route("user-configurations.update"),
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
          steps={form.steps}
          method={form.method}
          initialData={{
            color: color,
            language: locale,
            radius: radius,
          }}
          render={() => {
            return (
              <FormRoot className="gap-4">
                {form.steps.map((step, index) => {
                  return (
                    <Fragment key={index}>
                      {step.elements?.map((element, index) => {
                        return (
                          <FormElement
                            {...element}
                            registry={registry}
                            onChange={(value) =>
                              handleChange(element.id as string, value as number | string)
                            }
                            key={index}
                          />
                        );
                      })}
                    </Fragment>
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

import { router } from "@inertiajs/react";
import { FormElement, FormProvider, FormRoot } from "@narsil-cms/components/form";
import { useColorStore } from "@narsil-cms/stores/color-store";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import { useRadiusStore } from "@narsil-cms/stores/radius-store";
import type { FormType } from "@narsil-cms/types";
import { Heading } from "@narsil-ui/components/heading";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-ui/components/section";
import { useTranslator } from "@narsil-ui/components/translator";
import { Fragment } from "react";
import { route } from "ziggy-js";

type ConfigurationFormProps = {
  form: FormType;
};

function ConfigurationForm({ form }: ConfigurationFormProps) {
  const { color, setColor } = useColorStore();
  const { reloadTopModal } = useModalStore();
  const { radius, setRadius } = useRadiusStore();
  const { locale, trans } = useTranslator();

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
          elements={form.tabs}
          method={form.method}
          initialValues={{
            color: color,
            language: locale,
            radius: radius,
          }}
          render={() => {
            return (
              <FormRoot className="gap-4">
                {form.tabs.map((tab, index) => {
                  return (
                    <Fragment key={index}>
                      {tab.elements?.map((element, index) => {
                        return (
                          <FormElement
                            {...element}
                            onChange={(value) =>
                              handleChange(element.handle, value as number | string)
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

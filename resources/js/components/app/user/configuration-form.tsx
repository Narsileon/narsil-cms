import { Form, FormProvider } from "@/components/ui/form";
import { getSelectOption } from "@/lib/utils";
import { route } from "ziggy-js";
import { router } from "@inertiajs/react";
import { useLabels } from "@/components/ui/labels";
import { useLocale } from "@/hooks/use-props";
import { useModalStore } from "@/stores/modal-store";
import FormInputBlock from "@/blocks/form-input-block";
import useColorStore from "@/stores/color-store";
import useRadiusStore from "@/stores/radius-store";
import useThemeStore from "@/stores/theme-store";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import {
  LanguagesIcon,
  PaletteIcon,
  SquareRoundCornerIcon,
  SunMoonIcon,
} from "lucide-react";
import type { LaravelForm } from "@/types";

type ConfigurationFormProps = {
  form: LaravelForm;
};

function ConfigurationForm({ form }: ConfigurationFormProps) {
  const { getLabel } = useLabels();
  const { locale } = useLocale();

  const { reloadTopModal } = useModalStore();

  const { color, setColor } = useColorStore();
  const { radius, setRadius } = useRadiusStore();
  const { theme, setTheme } = useThemeStore();

  function getIcon(id: string) {
    switch (id) {
      case "color":
        return <PaletteIcon />;
      case "locale":
        return <LanguagesIcon />;
      case "radius":
        return <SquareRoundCornerIcon />;
      case "theme":
        return <SunMoonIcon />;
      default:
        return null;
    }
  }

  function getValue(id: string) {
    switch (id) {
      case "color":
        return color;
      case "locale":
        return locale;
      case "radius":
        return radius;
      case "theme":
        return theme;
      default:
        return "";
    }
  }

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
          content={form.content}
          initialValues={{
            color: color,
            locale: locale,
            radius: radius,
            theme: theme,
          }}
          render={() => (
            <Form
              className="gap-6 md:grid-cols-2"
              method={form.method}
              url={form.action}
            >
              {form.content.map(({ ...input }, index) => (
                <FormInputBlock
                  className="grid grid-cols-2"
                  icon={getIcon(input.handle)}
                  onChange={(value) => handleChange(input.handle, value)}
                  renderOption={
                    input.handle === "color"
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
                  {...input}
                  key={index}
                />
              ))}
            </Form>
          )}
        />
      </SectionContent>
    </Section>
  );
}

export default ConfigurationForm;

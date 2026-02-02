import { Badge } from "@narsil-cms/components/badge";
import { useLocalization } from "@narsil-cms/components/localization";
import { ToggleGroupItem, ToggleGroupRoot } from "@narsil-cms/components/toggle-group";
import { cn } from "@narsil-cms/lib/utils";
import { useMemo, type ComponentProps } from "react";
import useForm from "./form-context";

type FormLanguageProps = Omit<ComponentProps<typeof ToggleGroupRoot>, "type"> & {
  value: string;
  onValueChange: (value: string) => void;
};

function FormLanguage({ defaultValue, value, onValueChange, ...props }: FormLanguageProps) {
  const { defaultLanguage, languageOptions } = useForm();
  const { trans } = useLocalization();

  const orderedOptions = useMemo(() => {
    const defaultOption = languageOptions.filter((o) => o.value === defaultLanguage);
    const otherOptions = languageOptions
      .filter((o) => o.value !== defaultLanguage)
      .sort((a, b) => String(a.label).localeCompare(String(b.label)));

    return [...defaultOption, ...otherOptions];
  }, [defaultLanguage, languageOptions]);

  const currentOption =
    orderedOptions.find((option) => option.value === value) ?? orderedOptions[0];

  return (
    <ToggleGroupRoot
      defaultValue={[currentOption.value as string]}
      multiple={false}
      orientation="vertical"
      spacing={1}
      {...props}
    >
      {orderedOptions.map((option, index) => (
        <ToggleGroupItem
          className="flex w-full items-center justify-between pr-2"
          value={option.value as string}
          onClick={() => {
            onValueChange(option.value as string);
          }}
          key={option.value}
        >
          <span
            className={cn(
              "relative pl-5 font-normal",
              "before:absolute before:top-1/2 before:left-0 before:-translate-y-1/2",
              "before:size-1.5 before:rounded-full before:bg-constructive",
              option.value === value
                ? "before:animate-pulse before:bg-constructive"
                : "before:bg-foreground",
            )}
          >
            {option.label as string}
          </span>

          {option.value === defaultLanguage ? (
            <Badge className="bg-background" variant="outline">
              {trans("ui.default_language")}
            </Badge>
          ) : null}
        </ToggleGroupItem>
      ))}
    </ToggleGroupRoot>
  );
}

export default FormLanguage;

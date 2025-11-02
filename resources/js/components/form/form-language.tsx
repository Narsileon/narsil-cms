import { Badge } from "@narsil-cms/blocks";
import { useLocalization } from "@narsil-cms/components/localization";
import { ToggleGroupItem, ToggleGroupRoot } from "@narsil-cms/components/toggle-group";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
import useForm from "./form-context";

type FormLanguageProps = Omit<ComponentProps<typeof ToggleGroupRoot>, "type"> & {
  value: string;
  onValueChange: (value: string) => void;
};

function FormLanguage({
  className,
  defaultValue,
  value,
  onValueChange,
  ...props
}: FormLanguageProps) {
  const { languageOptions } = useForm();
  const { trans } = useLocalization();

  return languageOptions?.length > 0 ? (
    <ToggleGroupRoot
      className={cn(className)}
      defaultValue={languageOptions[0].value as string}
      orientation="vertical"
      type="single"
      {...props}
    >
      {languageOptions.map((option, index) => (
        <ToggleGroupItem
          className="flex w-full items-center justify-between"
          value={option.value as string}
          onClick={() => {
            onValueChange(option.value as string);
          }}
          key={option.value}
        >
          <span
            className={cn(
              "relative pl-4 font-normal",
              "before:absolute before:top-1/2 before:left-0 before:-translate-y-1/2",
              "before:size-1 before:rounded-full before:bg-constructive",
              option.value === value ? "before:bg-constructive" : "before:bg-foreground",
            )}
          >
            {option.label as string}
          </span>

          {index === 0 ? (
            <Badge className="bg-background" variant="outline">
              {trans("ui.default_language")}
            </Badge>
          ) : null}
        </ToggleGroupItem>
      ))}
    </ToggleGroupRoot>
  ) : null;
}

export default FormLanguage;

import { Checkbox } from "@narsil-cms/components/ui/checkbox";
import { cn } from "@narsil-cms/lib/utils";
import { Combobox } from "@narsil-cms/components/ui/combobox";
import { Input } from "@narsil-cms/components/ui/input";
import { isArray } from "lodash";
import { Slider } from "@narsil-cms/components/ui/slider";
import { Switch } from "@narsil-cms/components/ui/switch";
import {
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@narsil-cms/components/ui/form";
import type { Field } from "@narsil-cms/types/models";
import type { SelectOption } from "@narsil-cms/types/types";

type FormBlockProps = Field & {
  className?: string;
  icon?: React.ReactNode | string;
  onChange?: (value: any) => void;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
};

function FormInputBlock({
  className,
  conditions,
  description,
  handle,
  icon,
  name,
  settings,
  visibility,
  onChange,
  renderOption,
}: FormBlockProps) {
  const { type, ...props } = settings ?? {};

  return type ? (
    <FormField
      conditions={conditions}
      handle={handle}
      visibility={visibility}
      render={({ value, onFieldChange, ...field }) => {
        function handleOnChange(value: any) {
          onChange?.(value);
          onFieldChange(value);
        }

        return (
          <FormItem
            className={cn(
              "col-span-full",
              settings.type === "checkbox" && "flex-row-reverse justify-end",
              settings.className,
              className,
            )}
          >
            <FormLabel required={settings.required}>
              {icon}
              {name}
            </FormLabel>
            {settings.type === "checkbox" ? (
              <Checkbox
                {...props}
                checked={value}
                onCheckedChange={(checked) => handleOnChange(checked)}
                {...field}
              />
            ) : settings.type === "combobox" || settings.type === "select" ? (
              <Combobox
                {...props}
                options={settings.options}
                renderOption={renderOption}
                search={settings.type === "combobox"}
                value={value}
                setValue={(value) => handleOnChange(value)}
                {...field}
              />
            ) : settings.type === "range" ? (
              <Slider
                {...props}
                value={isArray(value) ? value : [value]}
                onValueChange={([value]) => handleOnChange(value)}
              />
            ) : settings.type === "switch" ? (
              <Switch
                {...props}
                checked={value}
                onCheckedChange={(value) => handleOnChange(value)}
              />
            ) : (
              <Input
                {...props}
                id={handle}
                value={value}
                type={type}
                onChange={(e) => handleOnChange(e.target.value)}
                {...field}
              />
            )}
            {description ? (
              <FormDescription>{description}</FormDescription>
            ) : null}
            <FormMessage />
          </FormItem>
        );
      }}
    />
  ) : null;
}

export default FormInputBlock;

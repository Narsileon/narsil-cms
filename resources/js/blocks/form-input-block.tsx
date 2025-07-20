import { Checkbox } from "@/components/ui/checkbox";
import { cn } from "@/lib/utils";
import { Combobox } from "@/components/ui/combobox";
import { Input } from "@/components/ui/input";
import { isArray } from "lodash";
import { Slider } from "@/components/ui/slider";
import { Switch } from "@/components/ui/switch";
import {
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import type { FieldModel, SelectOption } from "@/types";

type FormBlockProps = FieldModel & {
  className?: string;
  icon?: React.ReactNode | string;
  onChange?: (value: any) => void;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
};

function FormInputBlock({
  className,
  description,
  icon,
  name,
  handle,
  settings,
  onChange,
  renderOption,
}: FormBlockProps) {
  const { type, ...props } = settings;

  return (
    <FormField
      handle={handle}
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
              settings.type === "switch" && "flex-row justify-between",
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
                id={handle}
                value={value}
                type={type}
                onChange={(e) => handleOnChange(e.target.value)}
                {...props}
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
  );
}

export default FormInputBlock;

import { Checkbox } from "@/components/ui/checkbox";
import { cn } from "@/lib/utils";
import { Combobox } from "@/components/ui/combobox";
import { Input } from "@/components/ui/input";
import { Slider } from "@/components/ui/slider";
import {
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import type { LaravelFormInput, SelectOption } from "@/types";

type FormBlockProps = LaravelFormInput & {
  className?: string;
  icon?: React.ReactNode | string;
  onChange?: (value: any) => void;
  renderOption?: (option: SelectOption | string) => React.ReactNode;
};

function FormInputBlock({
  autoComplete,
  className,
  column = false,
  description,
  icon,
  id,
  label,
  max,
  min,
  placeholder,
  options = [],
  required = false,
  step,
  type = "text",
  onChange,
  renderOption,
}: FormBlockProps) {
  return (
    <FormField
      name={id}
      render={({ value, onFieldChange, ...field }) => {
        function handleOnChange(value: any) {
          onChange?.(value);
          onFieldChange(value);
        }

        return (
          <FormItem
            className={cn(
              !column && "col-span-full",
              type === "checkbox" && "flex-row-reverse justify-end",
              className,
            )}
          >
            <FormLabel required={required}>
              {icon}
              {label}
            </FormLabel>
            {type === "checkbox" ? (
              <Checkbox
                checked={value}
                onCheckedChange={(checked) => handleOnChange(checked)}
                {...field}
              />
            ) : type === "combobox" || type === "select" ? (
              <Combobox
                options={options}
                placeholder={placeholder}
                renderOption={renderOption}
                search={type === "combobox"}
                value={value}
                setValue={(value) => handleOnChange(value)}
                {...field}
              />
            ) : type === "slider" ? (
              <Slider
                max={max}
                min={min}
                step={step}
                value={[value]}
                onValueChange={([value]) => handleOnChange(value)}
              />
            ) : (
              <Input
                autoComplete={autoComplete}
                placeholder={placeholder}
                type={type}
                value={value}
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
  );
}

export default FormInputBlock;

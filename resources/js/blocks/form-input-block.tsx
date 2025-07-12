import { Checkbox } from "@/components/ui/checkbox";
import { cn } from "@/lib/utils";
import { Combobox } from "@/components/ui/combobox";
import { Input } from "@/components/ui/input";
import {
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import type { LaravelFormInput } from "@/types/global";

type FormBlockProps = LaravelFormInput & {
  emptyLabel?: string;
  requiredLabel?: string;
};

function FormInputBlock({
  autoComplete,
  column = false,
  description,
  emptyLabel,
  id,
  label,
  placeholder,
  options = [],
  required = false,
  requiredLabel,
  type = "text",
}: FormBlockProps) {
  return (
    <FormField
      name={id}
      render={({ value, onChange, ...field }) => (
        <FormItem
          className={cn(
            !column && "col-span-full",
            type === "checkbox" && "flex-row-reverse justify-end",
          )}
        >
          <FormLabel required={required} requiredLabel={requiredLabel}>
            {label}
          </FormLabel>
          {type === "checkbox" ? (
            <Checkbox
              checked={value}
              onCheckedChange={(checked) => onChange(checked)}
              {...field}
            />
          ) : type === "combobox" ? (
            <Combobox
              options={options}
              emptyLabel={emptyLabel}
              placeholder={placeholder}
              value={value}
              setValue={(value) => onChange(value)}
              {...field}
            />
          ) : (
            <Input
              autoComplete={autoComplete}
              placeholder={placeholder}
              type={type}
              value={value}
              onChange={(e) => onChange(e.target.value)}
              {...field}
            />
          )}
          {description ? (
            <FormDescription>{description}</FormDescription>
          ) : null}
          <FormMessage />
        </FormItem>
      )}
    />
  );
}

export default FormInputBlock;

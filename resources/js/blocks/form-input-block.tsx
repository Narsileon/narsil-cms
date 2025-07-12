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

type FormBlockProps = LaravelFormInput & {};

function FormInputBlock({
  autoComplete,
  column = false,
  description,
  id,
  label,
  options = [],
  required = false,
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
          <FormLabel required={required}>{label}</FormLabel>
          {type === "checkbox" ? (
            <Checkbox
              checked={value}
              onCheckedChange={(checked) => onChange(checked)}
              {...field}
            />
          ) : type === "combobox" ? (
            <Combobox
              options={options}
              value={value}
              setValue={(value) => onChange(value)}
              {...field}
            />
          ) : (
            <Input
              autoComplete={autoComplete}
              value={value}
              type={type}
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

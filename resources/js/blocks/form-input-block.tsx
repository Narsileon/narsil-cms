import { Checkbox } from "@/components/ui/checkbox";
import { cn } from "@/lib/utils";
import { Input } from "@/components/ui/input";
import {
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
  id,
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
          <FormLabel required={required} />
          {type === "checkbox" ? (
            <Checkbox
              checked={value}
              onCheckedChange={(checked) => onChange(checked)}
              {...field}
            />
          ) : (
            <Input
              autoComplete={autoComplete}
              onChange={(e) => onChange(e.target.value)}
              type={type}
              value={value}
              {...field}
            />
          )}
          <FormMessage />
        </FormItem>
      )}
    />
  );
}

export default FormInputBlock;

import { AsteriskIcon } from "lucide-react";
import { cn } from "@/lib/utils";
import { Label as LabelPrimitive } from "radix-ui";
import { useFormField } from "./form-field";

export type FormLabelProps = React.ComponentProps<
  typeof LabelPrimitive.Root
> & {
  required?: boolean;
};

function FormLabel({
  children,
  className,
  required = false,
  ...props
}: FormLabelProps) {
  const { error, name } = useFormField();

  return (
    <LabelPrimitive.Label
      data-slot="form-label"
      data-error={!!error}
      className={cn(
        "flex items-center gap-x-1",
        "data-[error=true]:text-destructive",
        className,
      )}
      htmlFor={name}
      {...props}
    >
      {children}
      {required && (
        <AsteriskIcon className="text-destructive size-3" aria-hidden="true" />
      )}
    </LabelPrimitive.Label>
  );
}

export default FormLabel;

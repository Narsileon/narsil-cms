import { Label } from "@narsil-cms/blocks/label";
import { LabelRequired } from "@narsil-cms/components/label";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
import useFormField from "./form-field-context";

type FormLabelProps = ComponentProps<typeof Label> & {
  required?: boolean;
};

function FormLabel({ children, className, required = false, ...props }: FormLabelProps) {
  const { error, handle } = useFormField();

  return (
    <Label
      data-slot="form-label"
      data-error={!!error}
      className={cn("min-h-7 items-center data-[error=true]:text-destructive", className)}
      htmlFor={handle}
      {...props}
    >
      <span className="first-letter:uppercase">{children}</span>
      {required && <LabelRequired />}
    </Label>
  );
}

export default FormLabel;

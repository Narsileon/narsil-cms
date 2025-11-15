import { Label, Tooltip } from "@narsil-cms/blocks";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
import useFormField from "./form-field-context";

type FormLabelProps = ComponentProps<typeof Label> & {
  required?: boolean;
};

function FormLabel({ children, className, required = false, ...props }: FormLabelProps) {
  const { trans } = useLocalization();

  const { error, handle } = useFormField();

  return (
    <Label
      data-slot="form-label"
      data-error={!!error}
      className={cn("data-[error=true]:text-destructive", className)}
      htmlFor={handle}
      {...props}
    >
      <span className="first-letter:uppercase">{children}</span>
      {required && (
        <Tooltip tooltip={trans("accessibility.required")}>
          <span className="text-red-500">*</span>
        </Tooltip>
      )}
    </Label>
  );
}

export default FormLabel;

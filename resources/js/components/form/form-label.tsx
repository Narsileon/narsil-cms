import { type ComponentProps } from "react";

import { Label, Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";

import useFormField from "./form-field-context";

type FormLabelProps = ComponentProps<typeof Label> & {
  required?: boolean;
};

function FormLabel({
  children,
  className,
  required = false,
  ...props
}: FormLabelProps) {
  const { trans } = useLabels();

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
          <Icon
            className="!size-3 text-primary"
            aria-hidden="true"
            name="asterisk"
          />
        </Tooltip>
      )}
    </Label>
  );
}

export default FormLabel;

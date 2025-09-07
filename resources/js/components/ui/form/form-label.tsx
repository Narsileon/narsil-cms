import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Label as LabelPrimitive } from "radix-ui";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/ui/labels";
import useFormField from "./form-field-context";

type FormLabelProps = React.ComponentProps<typeof LabelPrimitive.Root> & {
  required?: boolean;
  requiredLabel?: string;
};

function FormLabel({
  children,
  className,
  required = false,
  requiredLabel,
  ...props
}: FormLabelProps) {
  const { trans } = useLabels();

  const { error, handle } = useFormField();

  return (
    <LabelPrimitive.Label
      data-slot="form-label"
      data-error={!!error}
      className={cn(
        "flex items-center gap-1 text-sm leading-none font-medium select-none",
        "group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50",
        "peer-disabled:cursor-not-allowed peer-disabled:opacity-50",
        "data-[error=true]:text-destructive",
        "[&>svg:first-child]:mr-1 [&>svg:first-child]:size-5",
        className,
      )}
      htmlFor={handle}
      {...props}
    >
      <span className="first-letter:uppercase">{children}</span>
      {required && (
        <Tooltip tooltip={trans("accessibility.required")}>
          <Icon
            className="text-destructive !size-3"
            aria-hidden="true"
            name="asterisk"
          />
        </Tooltip>
      )}
    </LabelPrimitive.Label>
  );
}

export default FormLabel;

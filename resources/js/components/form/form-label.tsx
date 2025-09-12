import { Label as LabelPrimitive } from "radix-ui";

import { Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";

import useFormField from "./form-field-context";

type FormLabelProps = React.ComponentProps<typeof LabelPrimitive.Root> & {
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
            className="!size-3 text-destructive"
            aria-hidden="true"
            name="asterisk"
          />
        </Tooltip>
      )}
    </LabelPrimitive.Label>
  );
}

export default FormLabel;

import { Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { LabelRoot } from "@narsil-cms/components/label";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";

import useFormField from "./form-field-context";

type FormLabelProps = React.ComponentProps<typeof LabelRoot> & {
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
    <LabelRoot
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
            className="!size-3 text-destructive"
            aria-hidden="true"
            name="asterisk"
          />
        </Tooltip>
      )}
    </LabelRoot>
  );
}

export default FormLabel;

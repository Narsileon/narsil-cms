import { AsteriskIcon } from "lucide-react";
import { cn } from "@/lib/utils";
import { Label as LabelPrimitive } from "radix-ui";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
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
  const { error, handle } = useFormField();
  const { getLabel } = useLabels();

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
      {children}
      {required && (
        <Tooltip tooltip={getLabel("accessibility.required")}>
          <AsteriskIcon
            className="text-destructive !size-3"
            aria-hidden="true"
          />
        </Tooltip>
      )}
    </LabelPrimitive.Label>
  );
}

export default FormLabel;

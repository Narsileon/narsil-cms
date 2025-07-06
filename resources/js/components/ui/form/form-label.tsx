import { AsteriskIcon } from "lucide-react";
import { cn } from "@/lib/utils";
import { Label as LabelPrimitive } from "radix-ui";
import useFormField from "./form-field-context";
import useTranslationsStore from "@/stores/translations-store";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
} from "@/components/ui/tooltip";

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
  const { trans } = useTranslationsStore();

  return (
    <LabelPrimitive.Label
      data-slot="form-label"
      data-error={!!error}
      className={cn(
        "flex items-center text-sm leading-none font-medium select-none",
        "group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50",
        "peer-disabled:cursor-not-allowed peer-disabled:opacity-50",
        "data-[error=true]:text-destructive",
        className,
      )}
      htmlFor={name}
      {...props}
    >
      {children ?? trans(`validation.attributes.${name}`, name)}
      {required && (
        <Tooltip>
          <TooltipTrigger asChild={true}>
            <AsteriskIcon
              className="text-destructive size-3"
              aria-hidden="true"
            />
          </TooltipTrigger>
          <TooltipContent>
            {trans("accessibility.required", "This field is required.")}
          </TooltipContent>
        </Tooltip>
      )}
    </LabelPrimitive.Label>
  );
}

export default FormLabel;

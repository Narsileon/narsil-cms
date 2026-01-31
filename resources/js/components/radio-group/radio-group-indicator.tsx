import { Radio } from "@base-ui/react/radio";
import { cn } from "@narsil-cms/lib/utils";
import { CircleIcon } from "lucide-react";

function RadioGroupIndicator({ className, children, ...props }: Radio.Indicator.Props) {
  return (
    <Radio.Indicator
      data-slot="radio-group-indicator"
      className={cn(
        "flex size-4 items-center justify-center text-primary",
        "group-aria-invalid/radio-group-item:text-destructive",
        className,
      )}
      {...props}
    >
      {children ?? (
        <CircleIcon className="absolute top-1/2 left-1/2 size-2 -translate-x-1/2 -translate-y-1/2 fill-current" />
      )}
    </Radio.Indicator>
  );
}

export default RadioGroupIndicator;

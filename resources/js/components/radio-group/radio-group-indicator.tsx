import { RadioGroup } from "radix-ui";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type RadioGroupIndicatorProps = React.ComponentProps<
  typeof RadioGroup.Indicator
> & {};

function RadioGroupIndicator({
  className,
  ...props
}: RadioGroupIndicatorProps) {
  return (
    <RadioGroup.Indicator
      data-slot="radio-group-indicator"
      className={cn("relative flex items-center justify-center", className)}
      {...props}
    >
      <Icon
        className="absolute top-1/2 left-1/2 size-2 -translate-x-1/2 -translate-y-1/2 fill-primary"
        name="circle"
      />
    </RadioGroup.Indicator>
  );
}

export default RadioGroupIndicator;

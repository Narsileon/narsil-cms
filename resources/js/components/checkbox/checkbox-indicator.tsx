import { Checkbox as CheckboxPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type CheckboxIndicatorProps = React.ComponentProps<
  typeof CheckboxPrimitive.Indicator
> & {};

function CheckboxIndicator({ className, ...props }: CheckboxIndicatorProps) {
  return (
    <CheckboxPrimitive.Indicator
      data-slot="checkbox-indicator"
      className={cn(
        "flex items-center justify-center text-current transition-none",
        className,
      )}
      {...props}
    />
  );
}

export default CheckboxIndicator;

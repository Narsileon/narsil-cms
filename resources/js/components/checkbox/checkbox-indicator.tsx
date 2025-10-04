import { Checkbox } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type CheckboxIndicatorProps = ComponentProps<typeof Checkbox.Indicator>;

function CheckboxIndicator({ className, ...props }: CheckboxIndicatorProps) {
  return (
    <Checkbox.Indicator
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

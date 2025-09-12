import { Progress as ProgressPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ProgressIndicatorProps = React.ComponentProps<
  typeof ProgressPrimitive.Indicator
> & {
  value?: React.ComponentProps<typeof ProgressPrimitive.Root>["value"];
};

function ProgressIndicator({
  className,
  value,
  style,
  ...props
}: ProgressIndicatorProps) {
  return (
    <ProgressPrimitive.Indicator
      data-slot="progress-indicator"
      className={cn(
        "h-full w-full flex-1 bg-primary transition-all will-change-transform",
        className,
      )}
      style={{ ...style, transform: `translateX(-${100 - (value || 0)}%)` }}
      {...props}
    />
  );
}
export default ProgressIndicator;

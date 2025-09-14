import { Progress } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ProgressIndicatorProps = React.ComponentProps<
  typeof Progress.Indicator
> & {
  value?: React.ComponentProps<typeof Progress.Root>["value"];
};

function ProgressIndicator({
  className,
  value,
  style,
  ...props
}: ProgressIndicatorProps) {
  return (
    <Progress.Indicator
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

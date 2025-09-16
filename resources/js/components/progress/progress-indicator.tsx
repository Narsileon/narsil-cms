import { Progress } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ProgressIndicatorProps = React.ComponentProps<
  typeof Progress.Indicator
> & {};

function ProgressIndicator({ className, ...props }: ProgressIndicatorProps) {
  return (
    <Progress.Indicator
      data-slot="progress-indicator"
      className={cn(
        "h-full w-full flex-1 bg-primary transition-all will-change-transform",
        className,
      )}
      {...props}
    />
  );
}
export default ProgressIndicator;

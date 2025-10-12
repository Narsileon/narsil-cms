import { cn } from "@narsil-cms/lib/utils";
import { Progress } from "radix-ui";
import { type ComponentProps } from "react";

type ProgressIndicatorProps = ComponentProps<typeof Progress.Indicator>;

function ProgressIndicator({ className, ...props }: ProgressIndicatorProps) {
  return (
    <Progress.Indicator
      data-slot="progress-indicator"
      className={cn(
        "bg-primary h-full w-full flex-1 transition-all will-change-transform",
        className,
      )}
      {...props}
    />
  );
}
export default ProgressIndicator;

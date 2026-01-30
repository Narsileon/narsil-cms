import { Progress } from "@base-ui/react/progress";
import { cn } from "@narsil-cms/lib/utils";

function ProgressIndicator({ className, ...props }: Progress.Indicator.Props) {
  return (
    <Progress.Indicator
      data-slot="progress-indicator"
      className={cn("h-full bg-primary transition-all", className)}
      {...props}
    />
  );
}
export default ProgressIndicator;

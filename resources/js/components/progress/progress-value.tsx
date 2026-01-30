import { Progress } from "@base-ui/react/progress";
import { cn } from "@narsil-cms/lib/utils";

function ProgressValue({ className, ...props }: Progress.Value.Props) {
  return (
    <Progress.Value
      data-slot="progress-value"
      className={cn("ml-auto text-sm text-muted-foreground tabular-nums", className)}
      {...props}
    />
  );
}
export default ProgressValue;

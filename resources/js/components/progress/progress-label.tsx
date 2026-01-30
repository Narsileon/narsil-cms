import { Progress } from "@base-ui/react/progress";
import { cn } from "@narsil-cms/lib/utils";

function ProgressLabel({ className, ...props }: Progress.Label.Props) {
  return (
    <Progress.Label
      data-slot="progress-label"
      className={cn("font-medium", className)}
      {...props}
    />
  );
}
export default ProgressLabel;

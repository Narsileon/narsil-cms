import { Progress } from "@base-ui/react/progress";
import { cn } from "@narsil-cms/lib/utils";

function ProgressRoot({ className, ...props }: Progress.Root.Props) {
  return (
    <Progress.Root
      data-slot="progress-root"
      className={cn("flex flex-wrap gap-3", className)}
      {...props}
    />
  );
}
export default ProgressRoot;

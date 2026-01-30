import { Progress } from "@base-ui/react/progress";
import { cn } from "@narsil-cms/lib/utils";

function ProgressTrack({ className, ...props }: Progress.Track.Props) {
  return (
    <Progress.Track
      data-slot="progress-track"
      className={cn(
        "relative flex h-1 w-full items-center overflow-x-hidden rounded-full bg-muted",
        className,
      )}
      {...props}
    />
  );
}
export default ProgressTrack;

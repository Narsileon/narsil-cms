import { Progress } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type ProgressRootProps = ComponentProps<typeof Progress.Root> & {};

function ProgressRoot({ className, ...props }: ProgressRootProps) {
  return (
    <Progress.Root
      data-slot="progress-root"
      className={cn(
        "relative h-2 w-full overflow-hidden rounded-full bg-primary/20",
        className,
      )}
      {...props}
    />
  );
}
export default ProgressRoot;

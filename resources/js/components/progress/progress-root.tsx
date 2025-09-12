import { Progress as ProgressPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ProgressRootProps = React.ComponentProps<
  typeof ProgressPrimitive.Root
> & {};

function ProgressRoot({ className, ...props }: ProgressRootProps) {
  return (
    <ProgressPrimitive.Root
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

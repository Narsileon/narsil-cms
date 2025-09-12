import { cn } from "@narsil-cms/lib/utils";

type SkeletonProps = React.ComponentProps<"div"> & {};

function Skeleton({ className, ...props }: SkeletonProps) {
  return (
    <div
      data-slot="skeleton"
      className={cn("animate-pulse rounded-md bg-primary/10", className)}
      {...props}
    />
  );
}

export default Skeleton;

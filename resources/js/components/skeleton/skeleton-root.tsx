import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type SkeletonRootProps = ComponentProps<"div"> & {};

function SkeletonRoot({ className, ...props }: SkeletonRootProps) {
  return (
    <div
      data-slot="skeleton-root"
      className={cn("animate-pulse rounded-md bg-primary/10", className)}
      {...props}
    />
  );
}

export default SkeletonRoot;

import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type SkeletonProps = React.ComponentProps<"div"> & {};

function Skeleton({ className, ...props }: SkeletonProps) {
  return (
    <div
      data-slot="skeleton"
      className={cn("bg-primary/10 animate-pulse rounded-md", className)}
      {...props}
    />
  );
}

export default Skeleton;

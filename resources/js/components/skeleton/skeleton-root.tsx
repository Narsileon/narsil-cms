import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function SkeletonRoot({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="skeleton-root"
      className={cn("animate-pulse rounded-md bg-primary/10", className)}
      {...props}
    />
  );
}

export default SkeletonRoot;

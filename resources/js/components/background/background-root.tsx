import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type BackgroundRootProps = ComponentProps<"div">;

function BackgroundRoot({ className, ...props }: BackgroundRootProps) {
  return (
    <div
      data-slot="background-root"
      className={cn("absolute top-0 -z-10 size-full", className)}
      {...props}
    />
  );
}

export default BackgroundRoot;

import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function BackgroundRoot({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="background-root"
      className={cn("absolute top-0 -z-10 size-full", className)}
      {...props}
    />
  );
}

export default BackgroundRoot;

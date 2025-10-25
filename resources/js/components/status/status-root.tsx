import { cn } from "@narsil-cms/lib/utils";
import { ComponentProps } from "react";

type StatusRootProps = ComponentProps<"ul">;

function StatusRoot({ className, ...props }: StatusRootProps) {
  return (
    <ul
      className={cn(
        "group relative h-9 w-full",
        "[&>*:nth-child(1)]:left-0 [&>*:nth-child(2)]:left-1.5 [&>*:nth-child(3)]:left-3",
        "[&>*:nth-child(1)]:z-20 [&>*:nth-child(2)]:z-10 [&>*:nth-child(3)]:z-0",
        "[&>*:nth-child(2)]:duration-300 [&>*:nth-child(3)]:duration-300",
        "[&>*:nth-child(2)]:group-hover:translate-x-2 [&>*:nth-child(3)]:group-hover:translate-x-4",
        className,
      )}
      {...props}
    />
  );
}

export default StatusRoot;

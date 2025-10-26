import { cn } from "@narsil-cms/lib/utils";
import { ComponentProps } from "react";

type StatusRootProps = ComponentProps<"ul">;

function StatusRoot({ className, ...props }: StatusRootProps) {
  return (
    <ul
      className={cn(
        "group relative flex h-9 w-fit items-center gap-0.5",
        "delay-100 duration-300",
        "group-hover:translate-x-0",
        "[&>*:nth-child(2)]:-translate-x-2 [&>*:nth-child(3)]:-translate-x-4",
        "[&>*:nth-child(1)]:z-20 [&>*:nth-child(2)]:z-10 [&>*:nth-child(3)]:z-0",
        "[&>*:nth-child(2)]:group-hover:translate-x-0 [&>*:nth-child(3)]:group-hover:translate-x-0",
        className,
      )}
      {...props}
    />
  );
}

export default StatusRoot;

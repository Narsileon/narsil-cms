import { cn } from "@narsil-cms/lib/utils";
import { ComponentProps } from "react";

type StatusItemProps = ComponentProps<"li">;

function StatusItem({ className, ...props }: StatusItemProps) {
  return (
    <li
      className={cn("absolute top-3 size-3 rounded-full delay-100 duration-300", className)}
      {...props}
    />
  );
}

export default StatusItem;

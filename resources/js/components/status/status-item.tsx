import { Tooltip } from "@narsil-cms/blocks";
import { cn } from "@narsil-cms/lib/utils";
import { ComponentProps } from "react";

type StatusItemProps = ComponentProps<"li"> & {
  tooltip: string;
};

function StatusItem({ className, tooltip, ...props }: StatusItemProps) {
  return (
    <Tooltip
      tooltip={tooltip}
      contentProps={{
        className: "pointer-events-none",
      }}
    >
      <li
        className={cn("absolute top-3 size-3 rounded-full delay-100 duration-300", className)}
        {...props}
      />
    </Tooltip>
  );
}

export default StatusItem;

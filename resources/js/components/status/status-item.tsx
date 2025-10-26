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
        className={cn("size-3 shrink-0 rounded-full delay-100 duration-300", className)}
        {...props}
      />
    </Tooltip>
  );
}

export default StatusItem;

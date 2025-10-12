import { cn } from "@narsil-cms/lib/utils";
import { Tooltip } from "radix-ui";
import { type ComponentProps } from "react";

type TooltipArrowProps = ComponentProps<typeof Tooltip.Arrow>;

function TooltipArrow({ className, ...props }: TooltipArrowProps) {
  return (
    <Tooltip.Arrow
      className={cn(
        "bg-primary fill-primary z-50 size-2.5 translate-y-[calc(-50%_-_2px)] rotate-45",
        className,
      )}
      {...props}
    />
  );
}

export default TooltipArrow;

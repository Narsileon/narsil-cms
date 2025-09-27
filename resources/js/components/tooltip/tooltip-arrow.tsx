import { Tooltip } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type TooltipArrowProps = ComponentProps<typeof Tooltip.Arrow> & {};

function TooltipArrow({ className, ...props }: TooltipArrowProps) {
  return (
    <Tooltip.Arrow
      className={cn(
        "z-50 size-2.5 translate-y-[calc(-50%_-_2px)] rotate-45 bg-primary fill-primary",
        className,
      )}
      {...props}
    />
  );
}

export default TooltipArrow;

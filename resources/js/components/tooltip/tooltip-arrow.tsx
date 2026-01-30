import { cn } from "@narsil-cms/lib/utils";
import { Tooltip } from "radix-ui";
import { type ComponentProps } from "react";

type TooltipArrowProps = ComponentProps<typeof Tooltip.Arrow>;

function TooltipArrow({ className, ...props }: TooltipArrowProps) {
  return (
    <Tooltip.Arrow
      className={cn(
        "z-50 size-2.5 translate-y-[calc(-50%-2px)] rotate-45 bg-primary fill-primary",
        "data-[side=inline-start]:top-1/2! data-[side=inline-start]:-right-1 data-[side=inline-start]:-translate-y-1/2",
        "data-[side=inline-end]:top-1/2! data-[side=inline-end]:-left-1 data-[side=inline-end]:-translate-y-1/2",
        className,
      )}
      {...props}
    />
  );
}

export default TooltipArrow;

import { Tooltip } from "@base-ui/react/tooltip";
import { cn } from "@narsil-cms/lib/utils";

function TooltipArrow({ className, ...props }: Tooltip.Arrow.Props) {
  return (
    <Tooltip.Arrow
      className={cn(
        "z-50 size-2.5 translate-y-[calc(-50%-2px)] rotate-45 rounded-[2px] bg-foreground fill-foreground",
        "data-[side=bottom]:top-1",
        "data-[side=inline-end]:top-1/2! data-[side=inline-end]:-left-1 data-[side=inline-end]:-translate-y-1/2",
        "data-[side=inline-start]:top-1/2! data-[side=inline-start]:-right-1 data-[side=inline-start]:-translate-y-1/2",
        "data-[side=left]:top-1/2! data-[side=left]:-right-1 data-[side=left]:-translate-y-1/2",
        "data-[side=right]:top-1/2! data-[side=right]:-left-1 data-[side=right]:-translate-y-1/2",
        "data-[side=top]:-bottom-2.5",
        className,
      )}
      {...props}
    />
  );
}

export default TooltipArrow;

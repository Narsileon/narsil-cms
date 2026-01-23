import {
  TooltipArrow,
  TooltipContent,
  TooltipPortal,
  TooltipProvider,
  TooltipRoot,
  TooltipTrigger,
} from "@narsil-cms/components/tooltip";
import { type ComponentProps, type ReactNode } from "react";

type TooltipProps = ComponentProps<typeof TooltipRoot> & {
  arrowProps?: Partial<ComponentProps<typeof TooltipArrow>>;
  contentProps?: Partial<ComponentProps<typeof TooltipContent>>;
  portalProps?: Partial<ComponentProps<typeof TooltipPortal>>;
  triggerProps?: Partial<ComponentProps<typeof TooltipTrigger>>;
  tooltip: string | ReactNode;
};

function Tooltip({
  arrowProps,
  children,
  contentProps,
  portalProps,
  tooltip,
  triggerProps,
  ...props
}: TooltipProps) {
  return (
    <TooltipProvider>
      <TooltipRoot {...props}>
        <TooltipTrigger {...triggerProps}>{children}</TooltipTrigger>
        <TooltipPortal {...portalProps}>
          <TooltipContent {...contentProps}>
            {tooltip}
            <TooltipArrow {...arrowProps} />
          </TooltipContent>
        </TooltipPortal>
      </TooltipRoot>
    </TooltipProvider>
  );
}

export default Tooltip;

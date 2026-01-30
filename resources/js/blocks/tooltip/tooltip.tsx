import {
  TooltipArrow,
  TooltipPopup,
  TooltipPortal,
  TooltipPositioner,
  TooltipProvider,
  TooltipRoot,
  TooltipTrigger,
} from "@narsil-cms/components/tooltip";
import { type ComponentProps, type ReactNode } from "react";

type TooltipProps = ComponentProps<typeof TooltipRoot> & {
  arrowProps?: Partial<ComponentProps<typeof TooltipArrow>>;
  popupProps?: Partial<ComponentProps<typeof TooltipPopup>>;
  portalProps?: Partial<ComponentProps<typeof TooltipPortal>>;
  positionerProps?: Partial<ComponentProps<typeof TooltipPositioner>>;
  triggerProps?: Partial<ComponentProps<typeof TooltipTrigger>>;
  tooltip: string | ReactNode;
} & {
  children: ReactNode;
};

function Tooltip({
  arrowProps,
  children,
  popupProps,
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
          <TooltipPositioner>
            <TooltipPopup {...popupProps}>
              {tooltip}
              <TooltipArrow {...arrowProps} />
            </TooltipPopup>
          </TooltipPositioner>
        </TooltipPortal>
      </TooltipRoot>
    </TooltipProvider>
  );
}

export default Tooltip;

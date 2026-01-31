import {
  TooltipArrow,
  TooltipPopup,
  TooltipPortal,
  TooltipPositioner,
  TooltipProvider,
  TooltipRoot,
  TooltipTrigger,
} from "@narsil-cms/components/tooltip";
import { type ComponentProps, type ReactElement } from "react";

type TooltipProps = ComponentProps<typeof TooltipRoot> & {
  arrowProps?: Partial<ComponentProps<typeof TooltipArrow>>;
  popupProps?: Partial<ComponentProps<typeof TooltipPopup>>;
  portalProps?: Partial<ComponentProps<typeof TooltipPortal>>;
  positionerProps?: Partial<ComponentProps<typeof TooltipPositioner>>;
  providerProps?: Partial<ComponentProps<typeof TooltipProvider>>;
  tooltip: string | ReactElement;
  triggerProps?: Partial<ComponentProps<typeof TooltipTrigger>>;
} & {
  children: ReactElement;
};

function Tooltip({
  arrowProps,
  children,
  popupProps,
  portalProps,
  positionerProps,
  providerProps,
  tooltip,
  triggerProps,
  ...props
}: TooltipProps) {
  return (
    <TooltipProvider {...providerProps}>
      <TooltipRoot {...props}>
        <TooltipTrigger render={children} {...triggerProps} />
        <TooltipPortal {...portalProps}>
          <TooltipPositioner {...positionerProps}>
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

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

type TooltipProps = Pick<ComponentProps<typeof TooltipProvider>, "delay" | "timeout"> &
  Pick<ComponentProps<typeof TooltipPositioner>, "align" | "alignOffset" | "side" | "sideOffset"> &
  Pick<ComponentProps<typeof TooltipPopup>, "hidden"> & {
    children: ReactElement;
    tooltip: string | ReactElement;
  };

function Tooltip({
  align,
  alignOffset,
  children,
  delay = 300,
  hidden = false,
  side,
  sideOffset,
  timeout,
  tooltip,
}: TooltipProps) {
  return (
    <TooltipProvider delay={delay} timeout={timeout}>
      <TooltipRoot>
        <TooltipTrigger render={children} />
        <TooltipPortal>
          <TooltipPositioner
            align={align}
            alignOffset={alignOffset}
            side={side}
            sideOffset={sideOffset}
          >
            <TooltipPopup hidden={hidden}>
              {tooltip}
              <TooltipArrow />
            </TooltipPopup>
          </TooltipPositioner>
        </TooltipPortal>
      </TooltipRoot>
    </TooltipProvider>
  );
}

export default Tooltip;

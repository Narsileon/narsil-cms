import * as React from "react";
import {
  TooltipContent,
  TooltipRoot,
  TooltipTrigger,
} from "@narsil-cms/components/tooltip";

type TooltipProps = React.ComponentProps<typeof TooltipContent> & {
  asChild?: boolean;
  tooltip: string | React.ReactNode;
};

function Tooltip({
  asChild = true,
  children,
  tooltip,
  ...props
}: TooltipProps) {
  return (
    <TooltipRoot>
      <TooltipTrigger asChild={asChild}>{children}</TooltipTrigger>
      <TooltipContent {...props}>{tooltip}</TooltipContent>
    </TooltipRoot>
  );
}

export default Tooltip;

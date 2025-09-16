import {
  TooltipArrow,
  TooltipContent,
  TooltipPortal,
  TooltipProvider,
  TooltipRoot,
  TooltipTrigger,
} from "@narsil-cms/components/tooltip";

type TooltipProps = React.ComponentProps<typeof TooltipRoot> & {
  arrowProps?: Partial<React.ComponentProps<typeof TooltipArrow>>;
  contentProps?: Partial<React.ComponentProps<typeof TooltipContent>>;
  portalProps?: Partial<React.ComponentProps<typeof TooltipPortal>>;
  triggerProps?: Partial<React.ComponentProps<typeof TooltipTrigger>>;
  tooltip: string | React.ReactNode;
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

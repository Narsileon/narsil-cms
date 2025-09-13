import {
  TooltipArrow,
  TooltipContent,
  TooltipPortal,
  TooltipProvider,
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
    <TooltipProvider>
      <TooltipRoot>
        <TooltipTrigger asChild={asChild}>{children}</TooltipTrigger>
        <TooltipPortal>
          <TooltipContent {...props}>
            {tooltip}
            <TooltipArrow />
          </TooltipContent>
        </TooltipPortal>
      </TooltipRoot>
    </TooltipProvider>
  );
}

export default Tooltip;

import { Tooltip } from "@base-ui/react/tooltip";

function TooltipProvider({ delay = 300, ...props }: Tooltip.Provider.Props) {
  return <Tooltip.Provider data-slot="tooltip-provider" delay={delay} {...props} />;
}

export default TooltipProvider;

import { Root } from "@radix-ui/react-tooltip";
import TooltipProvider from "./tooltip-provider";

export type TooltipProps = React.ComponentProps<typeof Root> & {};

function Tooltip({ ...props }: React.ComponentProps<typeof Root>) {
  return (
    <TooltipProvider>
      <Root data-slot="tooltip" {...props} />
    </TooltipProvider>
  );
}

export default Tooltip;

import { Provider } from "@radix-ui/react-tooltip";

export type TooltipProviderProps = React.ComponentProps<typeof Provider> & {};

function TooltipProvider({
  delayDuration = 0,
  ...props
}: TooltipProviderProps) {
  return (
    <Provider
      data-slot="tooltip-provider"
      delayDuration={delayDuration}
      {...props}
    />
  );
}

export default TooltipProvider;

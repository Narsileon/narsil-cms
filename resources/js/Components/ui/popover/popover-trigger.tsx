import { Trigger } from "@radix-ui/react-popover";

export type PopoverTriggerProps = React.ComponentProps<typeof Trigger> & {};

function PopoverTrigger({ ...props }: PopoverTriggerProps) {
  return <Trigger data-slot="popover-trigger" {...props} />;
}

export default PopoverTrigger;

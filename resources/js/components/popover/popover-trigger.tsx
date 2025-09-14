import { Popover } from "radix-ui";

type PopoverTriggerProps = React.ComponentProps<typeof Popover.Trigger> & {};

function PopoverTrigger({ ...props }: PopoverTriggerProps) {
  return <Popover.Trigger data-slot="popover-trigger" {...props} />;
}

export default PopoverTrigger;

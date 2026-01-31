import { Popover } from "@base-ui/react/popover";

function PopoverTrigger({ ...props }: Popover.Trigger.Props) {
  return <Popover.Trigger data-slot="popover-trigger" {...props} />;
}

export default PopoverTrigger;

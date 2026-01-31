import { Popover } from "@base-ui/react/popover";

function PopoverRoot({ ...props }: Popover.Root.Props) {
  return <Popover.Root data-slot="popover-root" {...props} />;
}

export default PopoverRoot;

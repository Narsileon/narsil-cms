import { Root } from "@radix-ui/react-popover";

export type PopoverProps = React.ComponentProps<typeof Root> & {};

function Popover({ ...props }: PopoverProps) {
  return <Root data-slot="popover" {...props} />;
}

export default Popover;

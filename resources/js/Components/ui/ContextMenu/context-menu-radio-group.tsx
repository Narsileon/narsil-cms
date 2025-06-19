import { RadioGroup } from "@radix-ui/react-context-menu";

export type ContextMenuRadioGroupProps = React.ComponentProps<
  typeof RadioGroup
> & {};

function ContextMenuRadioGroup({ ...props }: ContextMenuRadioGroupProps) {
  return <RadioGroup data-slot="context-menu-radio-group" {...props} />;
}

export default ContextMenuRadioGroup;

import { ContextMenu } from "radix-ui";

type ContextMenuRadioGroupProps = React.ComponentProps<
  typeof ContextMenu.RadioGroup
> & {};

function ContextMenuRadioGroup({ ...props }: ContextMenuRadioGroupProps) {
  return (
    <ContextMenu.RadioGroup data-slot="context-menu-radio-group" {...props} />
  );
}

export default ContextMenuRadioGroup;

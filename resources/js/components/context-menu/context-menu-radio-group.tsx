import { ContextMenu } from "radix-ui";
import { type ComponentProps } from "react";

type ContextMenuRadioGroupProps = ComponentProps<
  typeof ContextMenu.RadioGroup
> & {};

function ContextMenuRadioGroup({ ...props }: ContextMenuRadioGroupProps) {
  return (
    <ContextMenu.RadioGroup data-slot="context-menu-radio-group" {...props} />
  );
}

export default ContextMenuRadioGroup;

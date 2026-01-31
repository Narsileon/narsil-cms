import { ContextMenu } from "@base-ui/react/context-menu";

function ContextMenuRadioGroup({ ...props }: ContextMenu.RadioGroup.Props) {
  return <ContextMenu.RadioGroup data-slot="context-menu-radio-group" {...props} />;
}

export default ContextMenuRadioGroup;

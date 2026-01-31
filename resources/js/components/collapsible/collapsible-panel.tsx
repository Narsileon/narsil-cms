import { Collapsible } from "@base-ui/react/collapsible";

function CollapsiblePanel({ ...props }: Collapsible.Panel.Props) {
  return <Collapsible.Panel data-slot="collapsible-panel" {...props} />;
}

export default CollapsiblePanel;

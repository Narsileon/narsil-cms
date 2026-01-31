import { Collapsible } from "@base-ui/react/collapsible";

function CollapsibleRoot({ ...props }: Collapsible.Root.Props) {
  return <Collapsible.Root data-slot="collapsible-root" {...props} />;
}

export default CollapsibleRoot;

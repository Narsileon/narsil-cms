import { Collapsible } from "radix-ui";

type CollapsibleRootProps = React.ComponentProps<typeof Collapsible.Root> & {};

function CollapsibleRoot({ ...props }: CollapsibleRootProps) {
  return <Collapsible.Root data-slot="collapsible-root" {...props} />;
}

export default CollapsibleRoot;

import { Collapsible } from "radix-ui";
import { type ComponentProps } from "react";

type CollapsibleRootProps = ComponentProps<typeof Collapsible.Root> & {};

function CollapsibleRoot({ ...props }: CollapsibleRootProps) {
  return <Collapsible.Root data-slot="collapsible-root" {...props} />;
}

export default CollapsibleRoot;

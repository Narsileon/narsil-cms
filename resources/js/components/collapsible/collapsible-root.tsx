import * as React from "react";
import { Collapsible as CollapsiblePrimitive } from "radix-ui";

type CollapsibleRootProps = React.ComponentProps<
  typeof CollapsiblePrimitive.Root
> & {};

function CollapsibleRoot({ ...props }: CollapsibleRootProps) {
  return <CollapsiblePrimitive.Root data-slot="collapsible-root" {...props} />;
}

export default CollapsibleRoot;

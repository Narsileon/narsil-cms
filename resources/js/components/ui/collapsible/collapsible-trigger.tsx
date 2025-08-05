import * as React from "react";
import { Collapsible as CollapsiblePrimitive } from "radix-ui";

type CollapsibleTriggerProps = React.ComponentProps<
  typeof CollapsiblePrimitive.Trigger
> & {};

function CollapsibleTrigger({ ...props }: CollapsibleTriggerProps) {
  return (
    <CollapsiblePrimitive.Trigger data-slot="collapsible-trigger" {...props} />
  );
}

export default CollapsibleTrigger;

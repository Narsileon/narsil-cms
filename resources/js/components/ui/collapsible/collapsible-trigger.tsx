import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Collapsible as CollapsiblePrimitive } from "radix-ui";

type CollapsibleTriggerProps = React.ComponentProps<
  typeof CollapsiblePrimitive.Trigger
> & {};

function CollapsibleTrigger({ className, ...props }: CollapsibleTriggerProps) {
  return (
    <CollapsiblePrimitive.Trigger
      data-slot="collapsible-trigger"
      className={cn("cursor-pointer", className)}
      {...props}
    />
  );
}

export default CollapsibleTrigger;

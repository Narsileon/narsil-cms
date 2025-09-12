import { Collapsible as CollapsiblePrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

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

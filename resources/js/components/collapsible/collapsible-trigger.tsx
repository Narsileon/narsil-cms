import { Collapsible } from "radix-ui";
import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type CollapsibleTriggerProps = ComponentProps<typeof Collapsible.Trigger> & {};

function CollapsibleTrigger({ className, ...props }: CollapsibleTriggerProps) {
  return (
    <Collapsible.Trigger
      data-slot="collapsible-trigger"
      className={cn("cursor-pointer", className)}
      {...props}
    />
  );
}

export default CollapsibleTrigger;

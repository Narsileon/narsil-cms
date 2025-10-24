import { cn } from "@narsil-cms/lib/utils";
import { Collapsible } from "radix-ui";
import { type ComponentProps } from "react";

type CollapsibleTriggerProps = ComponentProps<typeof Collapsible.Trigger>;

function CollapsibleTrigger({ className, ...props }: CollapsibleTriggerProps) {
  return (
    <Collapsible.Trigger
      data-slot="collapsible-trigger"
      className={cn(
        "cursor-pointer focus-visible:border-shine data-disabled:cursor-default",
        className,
      )}
      {...props}
    />
  );
}

export default CollapsibleTrigger;

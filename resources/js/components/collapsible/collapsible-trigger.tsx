import { cn } from "@narsil-cms/lib/utils";
import { Collapsible } from "radix-ui";
import { type ComponentProps } from "react";

type CollapsibleTriggerProps = ComponentProps<typeof Collapsible.Trigger>;

function CollapsibleTrigger({ className, ...props }: CollapsibleTriggerProps) {
  return (
    <Collapsible.Trigger
      data-slot="collapsible-trigger"
      className={cn(
        "focus-visible:border-shine cursor-pointer data-[disabled]:cursor-default",
        className,
      )}
      {...props}
    />
  );
}

export default CollapsibleTrigger;

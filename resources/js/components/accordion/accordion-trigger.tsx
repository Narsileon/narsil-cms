import { Accordion as AccordionPrimitive } from "radix-ui";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type AccordionTriggerProps = React.ComponentProps<
  typeof AccordionPrimitive.Trigger
> & {};

function AccordionTrigger({
  className,
  children,
  ...props
}: AccordionTriggerProps) {
  return (
    <AccordionPrimitive.Header data-slot="accordion-header" className="flex">
      <AccordionPrimitive.Trigger
        data-slot="accordion-trigger"
        className={cn(
          "flex flex-1 items-start justify-between gap-4 rounded-md py-4 text-left text-sm font-medium transition-all outline-none",
          "disabled:pointer-events-none disabled:opacity-50",
          "focus-visible:border-ring focus-visible:ring-2 focus-visible:ring-ring/50",
          "hover:underline",
          "[&[data-state=open]>svg]:rotate-180",
          className,
        )}
        {...props}
      >
        {children}
        <Icon
          className={cn(
            "pointer-events-none size-4 shrink-0 text-muted-foreground",
            "translate-y-0.5 transition-transform duration-300 will-change-transform",
          )}
          name="chevron-down"
        />
      </AccordionPrimitive.Trigger>
    </AccordionPrimitive.Header>
  );
}

export default AccordionTrigger;

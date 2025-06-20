import { ChevronDown } from "lucide-react";
import { cn } from "@/components";
import { Header, Trigger } from "@radix-ui/react-accordion";

export type AccordionTriggerProps = React.ComponentProps<typeof Trigger> & {};

function AccordionTrigger({
  className,
  children,
  ...props
}: AccordionTriggerProps) {
  return (
    <Header className="flex">
      <Trigger
        data-slot="accordion-trigger"
        className={cn(
          "flex flex-1 items-start justify-between gap-4 rounded-md py-4 text-left text-sm font-medium transition-all outline-none",
          "disabled:pointer-events-none disabled:opacity-50",
          "focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]",
          "hover:underline",
          "[&[data-state=open]>svg]:rotate-180",
          className,
        )}
        {...props}
      >
        {children}
        <ChevronDown
          className={cn(
            "text-muted-foreground pointer-events-none size-4 shrink-0",
            "translate-y-0.5 transition-transform duration-200",
          )}
        />
      </Trigger>
    </Header>
  );
}

export default AccordionTrigger;

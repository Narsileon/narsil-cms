import { cn } from "@/Components";
import { Content } from "@radix-ui/react-accordion";

export type AccordionContentProps = React.ComponentProps<typeof Content> & {};

function AccordionContent({
  className,
  children,
  ...props
}: AccordionContentProps) {
  return (
    <Content
      data-slot="accordion-content"
      className={cn(
        "overflow-hidden text-sm transition-all",
        "data-[state=closed]:animate-accordion-up",
        "data-[state=open]:animate-accordion-down",
      )}
      {...props}
    >
      <div className={cn("pt-0 pb-4", className)}>{children}</div>
    </Content>
  );
}

export default AccordionContent;

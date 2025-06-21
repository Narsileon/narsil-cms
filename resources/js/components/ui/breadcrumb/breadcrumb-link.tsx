import { cn } from "@/lib/utils";
import { Slot as SlotPrimitive } from "radix-ui";

export type BreadcrumbLinkProps = React.ComponentProps<"a"> & {
  asChild?: boolean;
};

function BreadcrumbLink({ asChild, className, ...props }: BreadcrumbLinkProps) {
  const Comp = asChild ? SlotPrimitive.Slot : "a";

  return (
    <Comp
      data-slot="breadcrumb-link"
      className={cn("hover:text-foreground transition-colors", className)}
      {...props}
    />
  );
}

export default BreadcrumbLink;

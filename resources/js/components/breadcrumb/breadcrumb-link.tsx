import { Slot as SlotPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type BreadcrumbLinkProps = React.ComponentProps<"a"> & {
  asChild?: boolean;
};

function BreadcrumbLink({ asChild, className, ...props }: BreadcrumbLinkProps) {
  const Comp = asChild ? SlotPrimitive.Slot : "a";

  return (
    <Comp
      data-slot="breadcrumb-link"
      className={cn("transition-colors hover:text-foreground", className)}
      {...props}
    />
  );
}

export default BreadcrumbLink;

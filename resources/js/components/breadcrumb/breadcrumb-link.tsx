import { cn } from "@narsil-cms/lib/utils";
import { Slot } from "radix-ui";
import { type ComponentProps } from "react";

type BreadcrumbLinkProps = ComponentProps<"a"> & {
  asChild?: boolean;
};

function BreadcrumbLink({ asChild, className, ...props }: BreadcrumbLinkProps) {
  const Comp = asChild ? Slot.Root : "a";

  return (
    <Comp
      data-slot="breadcrumb-link"
      className={cn("hover:text-foreground transition-colors", className)}
      {...props}
    />
  );
}

export default BreadcrumbLink;

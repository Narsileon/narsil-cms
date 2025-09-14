import { type VariantProps } from "class-variance-authority";
import { Slot } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

import badgeRootVariants from "./badge-root-variants";

type BadgeRootProps = React.ComponentProps<"span"> &
  VariantProps<typeof badgeRootVariants> & { asChild?: boolean };

function BadgeRoot({
  asChild = false,
  className,
  variant,
  ...props
}: BadgeRootProps) {
  const Comp = asChild ? Slot.Root : "span";

  return (
    <Comp
      data-slot="badge"
      className={cn(badgeRootVariants({ variant }), className)}
      {...props}
    />
  );
}

export default BadgeRoot;

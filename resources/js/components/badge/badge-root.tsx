import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { Slot } from "radix-ui";
import { type ComponentProps } from "react";
import badgeRootVariants from "./badge-root-variants";

type BadgeRootProps = ComponentProps<"span"> &
  VariantProps<typeof badgeRootVariants> & { asChild?: boolean };

function BadgeRoot({ asChild = false, className, variant, ...props }: BadgeRootProps) {
  const Comp = asChild ? Slot.Root : "span";

  return (
    <Comp
      data-slot="badge-root"
      className={cn(
        badgeRootVariants({
          className: className,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default BadgeRoot;

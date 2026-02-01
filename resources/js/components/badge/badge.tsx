import { mergeProps, useRender } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import badgeRootVariants from "./badge-variants";

type BadgeProps = useRender.ComponentProps<"span"> & VariantProps<typeof badgeRootVariants>;

function Badge({ className, render, variant, ...props }: BadgeProps) {
  return useRender({
    defaultTagName: "span",
    props: mergeProps<"span">(
      {
        className: cn(badgeRootVariants({ className, variant })),
      },
      props,
    ),
    render,
    state: {
      slot: "badge",
      variant: variant,
    },
  });
}

export default Badge;

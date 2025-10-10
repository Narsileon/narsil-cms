import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";
import headingRootVariants from "./heading-root-variants";

type HeadingRootProps = ComponentProps<"h1"> &
  VariantProps<typeof headingRootVariants> & {
    level: "h1" | "h2" | "h3" | "h4" | "h5" | "h6";
  };

function HeadingRoot({ className, level, variant, ...props }: HeadingRootProps) {
  const Comp = level;

  return (
    <Comp
      data-slot="heading-root"
      className={cn(
        headingRootVariants({
          className: className,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default HeadingRoot;

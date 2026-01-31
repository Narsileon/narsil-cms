import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";
import headingVariants from "./heading-variants";

type HeadingProps = ComponentProps<"h1"> &
  VariantProps<typeof headingVariants> & {
    level?: "h1" | "h2" | "h3" | "h4" | "h5" | "h6";
  };

function Heading({ className, level = "h1", variant = "h6", ...props }: HeadingProps) {
  const Comp = level;

  return (
    <Comp
      data-slot="heading"
      className={cn(
        headingVariants({
          className: className,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default Heading;

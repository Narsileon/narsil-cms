import { type VariantProps } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

import headingRootVariants from "./heading-root-variants";

type HeadingRootProps = React.ComponentProps<"h1"> &
  VariantProps<typeof headingRootVariants> & {
    level: "h1" | "h2" | "h3" | "h4" | "h5" | "h6";
  };

function HeadingRoot({
  className,
  level,
  variant,
  ...props
}: HeadingRootProps) {
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

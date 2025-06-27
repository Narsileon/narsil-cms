import { cn } from "@/lib/utils";
import { cva } from "class-variance-authority";
import type { VariantProps } from "class-variance-authority";

export const headingVariants = cva("font-medium tracking-tight", {
  variants: {
    variant: {
      h1: "text-5xl",
      h2: "text-4xl",
      h3: "text-3xl",
      h4: "text-2xl",
      h5: "text-xl",
      h6: "base",
    },
  },
  defaultVariants: {
    variant: "h6",
  },
});

export type HeadingProps = React.ComponentProps<"h1"> &
  VariantProps<typeof headingVariants> & {
    level: "h1" | "h2" | "h3" | "h4" | "h5" | "h6";
  };

function Heading({ className, level, variant, ...props }: HeadingProps) {
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

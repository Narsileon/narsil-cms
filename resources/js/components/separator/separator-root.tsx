import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { Separator } from "radix-ui";
import { type ComponentProps } from "react";
import separatorRootVariants from "./separator-root-variants";

type SeparatorRootProps = ComponentProps<typeof Separator.Root> &
  VariantProps<typeof separatorRootVariants>;

function SeparatorRoot({
  className,
  decorative = true,
  orientation = "horizontal",
  variant = "default",
  ...props
}: SeparatorRootProps) {
  return (
    <Separator.Root
      data-slot="separator-root"
      className={cn(
        separatorRootVariants({
          className: className,
          variant: variant,
        }),
      )}
      decorative={decorative}
      orientation={orientation}
      {...props}
    />
  );
}

export default SeparatorRoot;

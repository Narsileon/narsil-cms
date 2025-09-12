import { Separator as SeparatorPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SeparatorRootProps = React.ComponentProps<
  typeof SeparatorPrimitive.Root
> & {};

function SeparatorRoot({
  className,
  decorative = true,
  orientation = "horizontal",
  ...props
}: SeparatorRootProps) {
  return (
    <SeparatorPrimitive.Root
      data-slot="separator-root"
      className={cn(
        "shrink-0 bg-border",
        "data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full",
        "data-[orientation=vertical]:h-full data-[orientation=vertical]:w-px",
        className,
      )}
      decorative={decorative}
      orientation={orientation}
      {...props}
    />
  );
}

export default SeparatorRoot;

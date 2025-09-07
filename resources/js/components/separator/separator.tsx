import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Separator as SeparatorPrimitive } from "radix-ui";

type SeparatorProps = React.ComponentProps<typeof SeparatorPrimitive.Root> & {};

function Separator({
  className,
  decorative = true,
  orientation = "horizontal",
  ...props
}: SeparatorProps) {
  return (
    <SeparatorPrimitive.Root
      data-slot="separator"
      className={cn(
        "bg-border shrink-0",
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

export default Separator;

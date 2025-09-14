import { Separator } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SeparatorRootProps = React.ComponentProps<typeof Separator.Root> & {};

function SeparatorRoot({
  className,
  decorative = true,
  orientation = "horizontal",
  ...props
}: SeparatorRootProps) {
  return (
    <Separator.Root
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

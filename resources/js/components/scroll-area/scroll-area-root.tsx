import { ScrollArea as ScrollAreaPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ScrollAreaRootProps = React.ComponentProps<
  typeof ScrollAreaPrimitive.Root
> & {};

const ScrollAreaRoot = ({ className, ...props }: ScrollAreaRootProps) => {
  return (
    <ScrollAreaPrimitive.Root
      data-slot="scroll-area-root"
      className={cn("relative overflow-hidden", className)}
      {...props}
    />
  );
};

export default ScrollAreaRoot;

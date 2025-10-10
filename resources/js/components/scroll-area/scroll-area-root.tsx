import { cn } from "@narsil-cms/lib/utils";
import { ScrollArea } from "radix-ui";
import { type ComponentProps } from "react";

type ScrollAreaRootProps = ComponentProps<typeof ScrollArea.Root>;

const ScrollAreaRoot = ({ className, ...props }: ScrollAreaRootProps) => {
  return (
    <ScrollArea.Root
      data-slot="scroll-area-root"
      className={cn("relative overflow-hidden", className)}
      {...props}
    />
  );
};

export default ScrollAreaRoot;

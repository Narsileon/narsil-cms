import { ScrollArea } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type ScrollAreaRootProps = React.ComponentProps<typeof ScrollArea.Root> & {};

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

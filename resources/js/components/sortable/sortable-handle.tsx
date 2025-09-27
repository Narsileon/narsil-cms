import { type ComponentProps } from "react";

import { Button } from "@narsil-cms/blocks";
import { cn } from "@narsil-cms/lib/utils";

type SortableHandleProps = ComponentProps<typeof Button> & {
  isDragging?: boolean;
};

function SortableHandle({
  className,
  isDragging = false,
  ...props
}: SortableHandleProps) {
  return (
    <Button
      className={cn(
        "h-9 w-7 rounded-none bg-accent/85",
        isDragging ? "cursor-grabbing" : "cursor-grab",
        className,
      )}
      icon="grip-vertical"
      size="icon"
      variant="ghost"
      {...props}
    />
  );
}

export default SortableHandle;

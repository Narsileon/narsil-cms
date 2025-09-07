import * as React from "react";
import { Button } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";
import { Icon } from "@narsil-cms/components/icon";

type SortableHandleProps = React.ComponentProps<typeof Button> & {};

function SortableHandle({ className, ...props }: SortableHandleProps) {
  return (
    <Button
      className={cn("bg-accent/85 h-9 w-7 cursor-grab rounded-none", className)}
      size="icon"
      variant="ghost"
      {...props}
    >
      <Icon name="grip-vertical" />
    </Button>
  );
}

export default SortableHandle;

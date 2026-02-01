import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { Button } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type SortableHandleProps = ComponentProps<typeof Button> & {
  isDragging?: boolean;
  label?: string;
};

function SortableHandle({
  className,
  isDragging = false,
  label = "Move",
  ...props
}: SortableHandleProps) {
  return (
    <Tooltip
      tooltip={label}
      popupProps={{
        hidden: isDragging,
      }}
    >
      <Button
        aria-label={label}
        className={cn(
          "h-9 w-7 rounded-none bg-accent/85",
          isDragging ? "cursor-grabbing" : "cursor-grab",
          className,
        )}
        size="icon"
        variant="ghost"
        {...props}
      >
        <Icon name="grip-vertical" />
      </Button>
    </Tooltip>
  );
}

export default SortableHandle;

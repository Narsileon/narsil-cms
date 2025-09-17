import { Button } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

type SortableHandleProps = React.ComponentProps<typeof Button> & {};

function SortableHandle({ className, ...props }: SortableHandleProps) {
  return (
    <Button
      className={cn("h-9 w-7 cursor-grab rounded-none bg-accent/85", className)}
      icon="grip-vertical"
      size="icon"
      variant="ghost"
      {...props}
    />
  );
}

export default SortableHandle;

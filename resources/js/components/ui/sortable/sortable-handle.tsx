import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { GripVertical } from "lucide-react";

type SortableHandleProps = React.ComponentProps<typeof Button> & {};

function SortableHandle({ className, ...props }: SortableHandleProps) {
  return (
    <Button
      className={cn("bg-accent/50 h-9 w-7 cursor-grab rounded-none", className)}
      size="icon"
      type="button"
      variant="ghost"
      {...props}
    >
      <GripVertical className="size-5" />
    </Button>
  );
}

export default SortableHandle;

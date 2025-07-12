import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { Tooltip } from "@/components/ui/tooltip";
import type { DraggableAttributes } from "@dnd-kit/core";
import type { SyntheticListenerMap } from "@dnd-kit/core/dist/hooks/utilities";

type DataTableHeadMoveProps = React.ComponentProps<typeof Button> & {
  attributes: DraggableAttributes;
  listeners: SyntheticListenerMap | undefined;
  moveLabel?: string;
};

function DataTableHeadMove({
  attributes,
  children,
  className,
  listeners,
  moveLabel,
  ...props
}: DataTableHeadMoveProps) {
  return (
    <Tooltip tooltip={moveLabel ?? "Move column"}>
      <Button
        aria-label={moveLabel ?? "Move column"}
        className={cn("px-2", className)}
        variant="ghost"
        {...props}
        {...attributes}
        {...listeners}
      >
        {children}
      </Button>
    </Tooltip>
  );
}

export default DataTableHeadMove;

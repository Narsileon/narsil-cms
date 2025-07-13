import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import type { DraggableAttributes } from "@dnd-kit/core";
import type { SyntheticListenerMap } from "@dnd-kit/core/dist/hooks/utilities";

type DataTableHeadMoveProps = React.ComponentProps<typeof Button> & {
  attributes: DraggableAttributes;
  listeners: SyntheticListenerMap | undefined;
};

function DataTableHeadMove({
  attributes,
  children,
  className,
  listeners,
  ...props
}: DataTableHeadMoveProps) {
  const getLabel = useLabels().getLabel;

  return (
    <Tooltip tooltip={getLabel("accessibility.move_column")}>
      <Button
        aria-label={getLabel("accessibility.move_column", "Move column")}
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

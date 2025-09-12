import { Button } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";
import { Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";
import { type DraggableAttributes } from "@dnd-kit/core";
import { type SyntheticListenerMap } from "@dnd-kit/core/dist/hooks/utilities";

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
  const { trans } = useLabels();

  return (
    <Tooltip tooltip={trans("accessibility.move_column")}>
      <Button
        aria-label={trans("accessibility.move_column", "Move column")}
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

import { type DraggableAttributes } from "@dnd-kit/core";
import { type SyntheticListenerMap } from "@dnd-kit/core/dist/hooks/utilities";

import { Button, Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";

type DataTableHeadMoveProps = React.ComponentProps<typeof Button> & {
  attributes: DraggableAttributes;
  listeners: SyntheticListenerMap | undefined;
};

function DataTableHeadMove({
  attributes,
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
      />
    </Tooltip>
  );
}

export default DataTableHeadMove;

import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { Tooltip } from "@/components/ui/tooltip";
import useTranslationsStore from "@/stores/translations-store";
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
  const { trans } = useTranslationsStore();

  return (
    <Tooltip tooltip={trans("accessibility.column_move", "Move column")}>
      <Button
        aria-label={trans("accessibility.column_move", "Move column")}
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

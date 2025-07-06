import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import useTranslationsStore from "@/stores/translations-store";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import type { ButtonProps } from "@/components/ui/button";
import type { DraggableAttributes } from "@dnd-kit/core";
import type { SyntheticListenerMap } from "@dnd-kit/core/dist/hooks/utilities";

export type DataTableHeadMoveProps = ButtonProps & {
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
    <Tooltip>
      <TooltipTrigger asChild={true}>
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
      </TooltipTrigger>
      <TooltipContent>
        {trans("accessibility.column_move", "Move column")}
      </TooltipContent>
    </Tooltip>
  );
}

export default DataTableHeadMove;

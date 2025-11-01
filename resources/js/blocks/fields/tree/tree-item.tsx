import { type UniqueIdentifier } from "@dnd-kit/core";
import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import Badge from "@narsil-cms/blocks/badge";
import { CardHeader, CardRoot, CardTitle } from "@narsil-cms/components/card";
import { CollapsibleRoot, CollapsibleTrigger } from "@narsil-cms/components/collapsible";
import { useLocalization } from "@narsil-cms/components/localization";
import { SortableHandle } from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
import { FlatNode, TreeItemMenu } from ".";

type TreeItemProps = Omit<ComponentProps<typeof CardRoot>, "id"> &
  Pick<ComponentProps<typeof TreeItemMenu>, "onMoveDown" | "onMoveUp" | "onRemove"> & {
    disabled?: boolean;
    id: UniqueIdentifier;
    item: FlatNode;
  };

function TreeItem({
  className,
  item,
  disabled,
  id,
  style,
  onMoveDown,
  onMoveUp,
  onRemove,
  ...props
}: TreeItemProps) {
  const { trans } = useLocalization();

  const {
    attributes,
    isDragging,
    listeners,
    transform,
    transition,
    setActivatorNodeRef,
    setNodeRef,
  } = useSortable({
    id: id,
  });

  return (
    <CollapsibleRoot
      ref={disabled ? undefined : setNodeRef}
      className={cn(isDragging && "opacity-50", className)}
      style={{
        ...style,
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
    >
      <CardRoot {...props}>
        <CollapsibleTrigger className={cn(disabled && "cursor-default")} asChild={true}>
          <CardHeader className="flex min-h-9 items-center justify-start gap-2 py-0 pr-1 pl-0">
            <SortableHandle
              ref={setActivatorNodeRef}
              {...attributes}
              {...listeners}
              disabled={disabled}
              tooltip={trans("ui.move")}
            />
            <div className="flex grow items-center justify-start gap-2">
              {item.label ? <CardTitle className="font-normal">{item.label}</CardTitle> : null}
              {item.badge ? <Badge variant="secondary">{item.badge}</Badge> : null}
            </div>
            <TreeItemMenu
              className="justify-end"
              item={item}
              onMoveDown={onMoveDown}
              onMoveUp={onMoveUp}
              onRemove={onRemove}
            />
          </CardHeader>
        </CollapsibleTrigger>
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default TreeItem;

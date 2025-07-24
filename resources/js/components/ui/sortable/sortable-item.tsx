import { AnimateLayoutChanges, useSortable } from "@dnd-kit/sortable";
import { cn } from "@narsil-cms/lib/utils";
import { CSS } from "@dnd-kit/utilities";
import type { FlatNode } from ".";

type SortableItemProps = React.ComponentProps<"div"> & {
  item: FlatNode;
};

const animateLayoutChanges: AnimateLayoutChanges = ({
  isSorting,
  wasDragging,
}) => (isSorting || wasDragging ? false : true);

function SortableItem({ className, item, ...props }: SortableItemProps) {
  const {
    attributes,
    isDragging,
    isSorting,
    listeners,
    transform,
    transition,
    setNodeRef,
  } = useSortable({
    id: item.id,
    animateLayoutChanges: animateLayoutChanges,
  });

  const style = {
    marginLeft: `${item.depth * 16}px`,
    opacity: isDragging ? 0.5 : 1,
    transform: CSS.Transform.toString(transform),
    transition: transition,
  };

  return (
    <div
      className={cn(
        "h-9 cursor-grab",
        isSorting && "cursor-grabbing",
        className,
      )}
      ref={setNodeRef}
      style={style}
      {...attributes}
      {...listeners}
      {...props}
    />
  );
}

export default SortableItem;

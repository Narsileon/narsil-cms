import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { Icon } from "@narsil-cms/blocks/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { SortableHandle, SortableItemMenu } from "@narsil-cms/components/sortable";
import { TableCell, TableRow } from "@narsil-cms/components/table";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type TableItemProps = Omit<ComponentProps<typeof TableRow>, "id"> &
  Pick<ComponentProps<typeof SortableItemMenu>, "onMoveDown" | "onMoveUp" | "onRemove"> & {
    colSpan?: number;
    disabled?: boolean;
    id: string;
    placeholder?: boolean;
  };

function TableItem({
  children,
  className,
  colSpan = 1,
  disabled,
  id,
  placeholder,
  style,
  onClick,
  onMoveDown,
  onMoveUp,
  onRemove,
  ...props
}: TableItemProps) {
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
    <TableRow
      ref={disabled ? undefined : setNodeRef}
      className={cn(
        "h-9",
        isDragging && "opacity-50",
        placeholder &&
          "border-dashed bg-transparent opacity-50 will-change-transform hover:opacity-100",
        onClick && "cursor-pointer",
        className,
      )}
      style={{
        ...style,
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
      onClick={onClick}
      {...props}
    >
      <TableCell className="px-1 py-0">
        {!placeholder ? (
          <SortableHandle
            ref={setActivatorNodeRef}
            className="rounded-md bg-transparent"
            {...attributes}
            {...listeners}
            label={trans("ui.move")}
          />
        ) : null}
      </TableCell>
      {placeholder ? (
        <TableCell colSpan={colSpan}>
          <div className="flex items-center justify-center gap-1">
            <Icon name="plus" />
            <span>{children}</span>
          </div>
        </TableCell>
      ) : (
        children
      )}
      <TableCell className="px-1 py-0">
        {!placeholder ? (
          <SortableItemMenu onMoveDown={onMoveDown} onMoveUp={onMoveUp} onRemove={onRemove} />
        ) : null}
      </TableCell>
    </TableRow>
  );
}

export default TableItem;

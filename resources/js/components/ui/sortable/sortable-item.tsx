import { cn } from "@narsil-cms/lib/utils";
import { CSS } from "@dnd-kit/utilities";
import { UniqueIdentifier } from "@dnd-kit/core";
import SortableHandle from "./sortable-handle";
import {
  AnimateLayoutChanges,
  defaultAnimateLayoutChanges,
  useSortable,
} from "@dnd-kit/sortable";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "@narsil-cms/components/ui/card";

type SortableItemProps = Omit<React.ComponentProps<typeof Card>, "id"> & {
  asChild?: boolean;
  data?: any;
  disabled?: boolean;
  header?: React.ReactNode;
  id: UniqueIdentifier;
  label?: UniqueIdentifier;
  placeholder?: boolean;
};

const animateLayoutChanges: AnimateLayoutChanges = (args) =>
  defaultAnimateLayoutChanges({ ...args, wasDragging: true });

function SortableItem({
  asChild = false,
  children,
  className,
  data,
  disabled,
  header,
  id,
  label,
  placeholder,
  style,
  ...props
}: SortableItemProps) {
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
    data: data,
    animateLayoutChanges: animateLayoutChanges,
  });

  return (
    <Card
      ref={disabled ? undefined : setNodeRef}
      className={cn(
        "overflow-hidden",
        isDragging && "opacity-50",
        placeholder &&
          "border-dashed bg-transparent opacity-50 hover:opacity-100",
        className,
      )}
      style={{
        ...style,
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
      {...props}
    >
      {placeholder ? (
        <CardContent className="flex h-full items-center justify-center">
          {children}
        </CardContent>
      ) : (
        <>
          <CardHeader
            className={cn(
              "flex min-h-11 items-center justify-between gap-2 !py-0 pr-1 pl-0",
              children && "border-b",
            )}
          >
            <SortableHandle
              ref={setActivatorNodeRef}
              {...attributes}
              {...listeners}
            />
            {label ? (
              <CardTitle className="grow justify-self-start font-normal">
                {label}
              </CardTitle>
            ) : null}

            {header}
          </CardHeader>
          {children ? <CardContent>{children}</CardContent> : null}
        </>
      )}
    </Card>
  );
}

export default SortableItem;

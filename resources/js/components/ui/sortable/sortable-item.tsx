import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { CSS } from "@dnd-kit/utilities";
import { EditIcon, TrashIcon } from "lucide-react";
import { ModalLink } from "@narsil-cms/components/ui/modal";
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
  CardFooter,
  CardHeader,
  CardTitle,
} from "@narsil-cms/components/ui/card";

type SortableItemProps = Omit<React.ComponentProps<typeof Card>, "id"> & {
  asChild?: boolean;
  data?: any;
  disabled?: boolean;
  footer?: React.ReactNode;
  header?: React.ReactNode;
  href?: string;
  id: UniqueIdentifier;
  label?: UniqueIdentifier;
  placeholder?: boolean;
  onRemove?: () => void;
};

const animateLayoutChanges: AnimateLayoutChanges = (args) =>
  defaultAnimateLayoutChanges({ ...args, wasDragging: true });

function SortableItem({
  asChild = false,
  children,
  className,
  data,
  disabled,
  footer,
  header,
  href,
  id,
  label,
  placeholder,
  style,
  onRemove,
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
              "flex min-h-9 items-center justify-between gap-2 !py-0 pr-1 pl-0",
              children && "border-b",
            )}
          >
            <SortableHandle
              ref={setActivatorNodeRef}
              {...attributes}
              {...listeners}
            />
            {label ? (
              <CardTitle className="grow justify-self-start text-sm font-normal">
                {label}
              </CardTitle>
            ) : null}
            {href ? (
              <Button
                className="size-7"
                size="icon"
                type="button"
                variant="ghost"
                asChild={true}
              >
                <ModalLink href={href}>
                  <EditIcon className="size-5" />
                </ModalLink>
              </Button>
            ) : null}
            {onRemove ? (
              <Button
                className="size-7"
                size="icon"
                type="button"
                variant="ghost"
                onClick={onRemove}
              >
                <TrashIcon className="size-5" />
              </Button>
            ) : null}
            {header}
          </CardHeader>
          {children ? <CardContent>{children}</CardContent> : null}
          {footer ? <CardFooter>{footer}</CardFooter> : null}
        </>
      )}
    </Card>
  );
}

export default SortableItem;

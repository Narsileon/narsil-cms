import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { CSS } from "@dnd-kit/utilities";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useSortable } from "@dnd-kit/sortable";
import SortableHandle from "./sortable-handle";
import SortableItemWidth from "./sortable-item-width";
import SortableItemForm from "./sortable-item-form";
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@narsil-cms/components/ui/card";
import type { AnonymousItem } from ".";
import type { UniqueIdentifier } from "@dnd-kit/core";
import type {
  FormType,
  GroupedSelectOption,
  SelectOption,
} from "@narsil-cms/types/forms";

type SortableItemProps = Omit<React.ComponentProps<typeof Card>, "id"> & {
  asChild?: boolean;
  disabled?: boolean;
  footer?: React.ReactNode;
  form?: FormType;
  group?: GroupedSelectOption;
  id: UniqueIdentifier;
  item: AnonymousItem;
  label?: UniqueIdentifier;
  optionValue?: string;
  placeholder?: boolean;
  tooltip?: string;
  widthOptions?: SelectOption[];
  onItemChange?: (value: AnonymousItem) => void;
  onItemRemove?: () => void;
};

function SortableItem({
  asChild = false,
  children,
  className,
  item,
  disabled,
  footer,
  form,
  group,
  id,
  label,
  optionValue,
  placeholder,
  style,
  widthOptions,
  onItemChange,
  onItemRemove,
  ...props
}: SortableItemProps) {
  const { getLabel } = useLabels();

  const {
    attributes,
    isDragging,
    items,
    listeners,
    transform,
    transition,
    setActivatorNodeRef,
    setNodeRef,
  } = useSortable({
    id: id,
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
            {item?.icon ? (
              <Tooltip tooltip={group?.label}>
                <Icon className="size-5" name={item.icon} />
              </Tooltip>
            ) : null}
            {label ? (
              <CardTitle className="grow justify-self-start text-sm font-normal">
                {label}
              </CardTitle>
            ) : null}
            <div className="flex items-center justify-between gap-1">
              {item && widthOptions ? (
                <SortableItemWidth
                  options={widthOptions}
                  value={item.width}
                  onValueChange={(value) =>
                    onItemChange?.({ ...item, width: value })
                  }
                />
              ) : null}
              {form && item && optionValue && onItemChange ? (
                <SortableItemForm
                  form={form}
                  ids={items}
                  item={item}
                  optionValue={optionValue}
                  onItemChange={onItemChange}
                >
                  <Button className="size-7" size="icon" variant="ghost">
                    <Icon name="edit" />
                  </Button>
                </SortableItemForm>
              ) : null}
              {onItemRemove ? (
                <Tooltip tooltip={getLabel("ui.remove")}>
                  <Button
                    className="size-7"
                    size="icon"
                    variant="ghost"
                    onClick={onItemRemove}
                  >
                    <Icon name="trash" />
                  </Button>
                </Tooltip>
              ) : null}
            </div>
          </CardHeader>
          {children ? (
            <CardContent className="grow">{children}</CardContent>
          ) : null}
          {footer ? (
            <CardFooter className="flex-col gap-4 border-t">
              {footer}
            </CardFooter>
          ) : null}
        </>
      )}
    </Card>
  );
}

export default SortableItem;

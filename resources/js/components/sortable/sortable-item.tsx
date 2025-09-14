import { type UniqueIdentifier } from "@dnd-kit/core";
import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { useState } from "react";

import { Tooltip } from "@narsil-cms/blocks";
import { ButtonRoot } from "@narsil-cms/components/button";
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@narsil-cms/components/card";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { cn } from "@narsil-cms/lib/utils";
import {
  type FormType,
  type GroupedSelectOption,
  type SelectOption,
} from "@narsil-cms/types";

import { type AnonymousItem } from ".";
import SortableHandle from "./sortable-handle";
import SortableItemForm from "./sortable-item-form";
import SortableItemWidth from "./sortable-item-width";

type SortableItemProps = Omit<React.ComponentProps<typeof Card>, "id"> & {
  collapsible?: boolean;
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
  children,
  className,
  collapsible = false,
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
  const { trans } = useLabels();

  const [open, setCollapsed] = useState<boolean>(true);

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
    <CollapsibleRoot
      ref={disabled ? undefined : setNodeRef}
      className={cn(
        "overflow-hidden",
        isDragging && "opacity-50",
        placeholder &&
          "border-dashed bg-transparent opacity-50 will-change-transform hover:opacity-100",
        className,
      )}
      open={open}
      style={{
        ...style,
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
    >
      <Card {...props}>
        {placeholder ? (
          <CardContent className="flex h-full items-center justify-center">
            {children}
          </CardContent>
        ) : (
          <>
            <CollapsibleTrigger
              className={cn(children && open && "border-b")}
              asChild={true}
            >
              <CardHeader className="flex min-h-9 items-center justify-between gap-2 !py-0 pr-1 pl-0">
                <div className="flex items-center justify-start gap-2">
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
                    <CardTitle className="justify-self-start text-sm font-normal">
                      {label}
                    </CardTitle>
                  ) : null}
                  {collapsible ? (
                    <ButtonRoot
                      className="size-7"
                      size="icon"
                      variant="ghost"
                      onClick={() => setCollapsed(!open)}
                    >
                      <Icon
                        className={cn("duration-300", open && "rotate-180")}
                        name="chevron-down"
                      />
                    </ButtonRoot>
                  ) : null}
                </div>
                <div className="flex items-center justify-between gap-1 justify-self-end">
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
                      <ButtonRoot
                        className="size-7"
                        size="icon"
                        variant="ghost"
                      >
                        <Icon name="edit" />
                      </ButtonRoot>
                    </SortableItemForm>
                  ) : null}
                  {onItemRemove ? (
                    <Tooltip tooltip={trans("ui.remove")}>
                      <ButtonRoot
                        className="size-7"
                        size="icon"
                        variant="ghost"
                        onClick={onItemRemove}
                      >
                        <Icon name="trash" />
                      </ButtonRoot>
                    </Tooltip>
                  ) : null}
                </div>
              </CardHeader>
            </CollapsibleTrigger>
            <CollapsibleContent>
              {children ? (
                <CardContent className="grow">{children}</CardContent>
              ) : null}
              {footer ? (
                <CardFooter className="flex-col gap-4 border-t">
                  {footer}
                </CardFooter>
              ) : null}
            </CollapsibleContent>
          </>
        )}
      </Card>
    </CollapsibleRoot>
  );
}

export default SortableItem;

import { type UniqueIdentifier } from "@dnd-kit/core";
import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { Button } from "@narsil-cms/blocks/button";
import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { WidthSelector } from "@narsil-cms/blocks/width-selector";
import {
  CardContent,
  CardFooter,
  CardHeader,
  CardRoot,
  CardTitle,
} from "@narsil-cms/components/card";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { IconName } from "@narsil-cms/repositories/icons";
import type { FormType, GroupedSelectOption, SelectOption } from "@narsil-cms/types";
import { useState, type ComponentProps } from "react";
import { type AnonymousItem } from ".";
import SortableHandle from "./sortable-handle";
import SortableItemForm from "./sortable-item-form";

type SortableItemProps = Omit<ComponentProps<typeof CardRoot>, "id"> & {
  collapsed?: boolean;
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
  collapsed = false,
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
  const { trans } = useLocalization();

  const [open, setCollapsed] = useState<boolean>(!collapsed);

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
        isDragging && "opacity-50",
        disabled && "pointer-events-none",
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
      <CardRoot {...props}>
        {placeholder ? (
          <CardContent className="flex h-full items-center justify-center">{children}</CardContent>
        ) : (
          <>
            <CollapsibleTrigger className={cn(children && open && "border-b")} asChild={true}>
              <CardHeader className="flex min-h-9 items-center justify-between gap-2 py-0! pr-1 pl-0">
                <div className="flex w-full items-center justify-start gap-2">
                  <SortableHandle
                    ref={setActivatorNodeRef}
                    {...attributes}
                    {...listeners}
                    disabled={disabled}
                    tooltip={trans("ui.move")}
                  />
                  {item?.icon ? (
                    <Tooltip tooltip={group?.label as string}>
                      <Icon className="size-5" name={item.icon as IconName} />
                    </Tooltip>
                  ) : null}
                  {label ? (
                    <CardTitle className="grow justify-self-start font-normal">{label}</CardTitle>
                  ) : null}
                  {collapsible ? (
                    <Button
                      iconProps={{
                        className: cn("duration-300", open && "rotate-180"),
                        name: "chevron-down",
                      }}
                      size="icon-sm"
                      variant="ghost"
                      onClick={() => setCollapsed(!open)}
                    />
                  ) : null}
                </div>
                <div className="flex items-center justify-between gap-1 justify-self-end">
                  {item && widthOptions ? (
                    <WidthSelector
                      options={widthOptions}
                      value={item.width as number}
                      onValueChange={(value) => onItemChange?.({ ...item, width: value })}
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
                      <Button icon="edit" size="icon-sm" variant="ghost" />
                    </SortableItemForm>
                  ) : null}
                  {onItemRemove ? (
                    <Button
                      icon="trash"
                      size="icon-sm"
                      tooltip={trans("ui.remove")}
                      variant="ghost"
                      onClick={onItemRemove}
                    />
                  ) : null}
                </div>
              </CardHeader>
            </CollapsibleTrigger>
            <CollapsibleContent>
              {children ? <CardContent className="grow">{children}</CardContent> : null}
              {footer ? (
                <CardFooter className="flex-col gap-4 border-t">{footer}</CardFooter>
              ) : null}
            </CollapsibleContent>
          </>
        )}
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default SortableItem;

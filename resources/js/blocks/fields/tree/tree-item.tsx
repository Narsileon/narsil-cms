import { type UniqueIdentifier } from "@dnd-kit/core";
import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { Button } from "@narsil-cms/blocks";
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
import { SortableHandle, SortableItemForm } from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import type { FormType } from "@narsil-cms/types";
import { useState, type ComponentProps } from "react";
import { FlatNode } from ".";

type TreeItemProps = Omit<ComponentProps<typeof CardRoot>, "id"> & {
  collapsed?: boolean;
  collapsible?: boolean;
  disabled?: boolean;
  footer?: React.ReactNode;
  form?: FormType;
  id: UniqueIdentifier;
  item: FlatNode;
  label?: UniqueIdentifier;
  optionValue?: string;
  placeholder?: boolean;
  tooltip?: string;
  onItemChange?: (value: FlatNode) => void;
  onItemRemove?: () => void;
};

function TreeItem({
  children,
  className,
  collapsed = false,
  collapsible = false,
  item,
  disabled,
  footer,
  form,
  id,
  label,
  optionValue,
  placeholder,
  style,
  onItemChange,
  onItemRemove,
  ...props
}: TreeItemProps) {
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
              <CardHeader className="flex min-h-9 items-center justify-between gap-2 !py-0 pl-0 pr-1">
                <div className="flex w-full items-center justify-start gap-2">
                  <SortableHandle
                    ref={setActivatorNodeRef}
                    {...attributes}
                    {...listeners}
                    disabled={disabled}
                    tooltip={trans("ui.move")}
                  />
                  {label ? (
                    <CardTitle className="grow justify-self-start font-normal">{label}</CardTitle>
                  ) : null}
                  {collapsible ? (
                    <Button
                      className="size-7"
                      iconProps={{
                        className: cn("duration-300", open && "rotate-180"),
                        name: "chevron-down",
                      }}
                      size="icon"
                      variant="ghost"
                      onClick={() => setCollapsed(!open)}
                    />
                  ) : null}
                </div>
                <div className="flex items-center justify-between gap-1 justify-self-end">
                  {form && item && optionValue && onItemChange ? (
                    <SortableItemForm
                      form={form}
                      ids={items}
                      item={item}
                      optionValue={optionValue}
                      onItemChange={onItemChange}
                    >
                      <Button className="size-7" icon="edit" size="icon" variant="ghost" />
                    </SortableItemForm>
                  ) : null}
                  {onItemRemove ? (
                    <Button
                      className="size-7"
                      icon="trash"
                      size="icon"
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

export default TreeItem;

import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { CSS } from "@dnd-kit/utilities";
import { get, set } from "lodash";
import { Icon } from "@narsil-cms/components/ui/icon";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";
import SortableHandle from "./sortable-handle";
import WidthSelector from "@narsil-cms/components/cms/width-selector";
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
import {
  Dialog,
  DialogBody,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@narsil-cms/components/ui/dialog";
import {
  FormInputRenderer,
  FormItem,
  FormLabel,
} from "@narsil-cms/components/ui/form";
import type { AnonymousItem } from ".";
import type {
  Field,
  GroupedSelectOption,
  SelectOption,
} from "@narsil-cms/types/forms";
import type { UniqueIdentifier } from "@dnd-kit/core";

type SortableItemProps = Omit<React.ComponentProps<typeof Card>, "id"> & {
  asChild?: boolean;
  disabled?: boolean;
  footer?: React.ReactNode;
  form?: Field[];
  group?: GroupedSelectOption;
  id: UniqueIdentifier;
  item: AnonymousItem;
  label?: UniqueIdentifier;
  placeholder?: boolean;
  tooltip?: string;
  widthOptions?: SelectOption[];
  onItemChange?: (value: AnonymousItem) => void;
  onItemRemove?: () => void;
};

const animateLayoutChanges: AnimateLayoutChanges = (args) =>
  defaultAnimateLayoutChanges({ ...args, wasDragging: true });

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
  placeholder,
  style,
  widthOptions,
  onItemChange,
  onItemRemove,
  ...props
}: SortableItemProps) {
  const { getLabel } = useLabels();

  const [open, onOpenChange] = React.useState<boolean>(false);

  const [data, setData] = React.useState<AnonymousItem>(item);
  const [error, setError] = React.useState<string | null>(null);

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
            {data?.icon ? (
              <Tooltip tooltip={group?.label}>
                <Icon className="size-5" name={data.icon} />
              </Tooltip>
            ) : null}
            {label ? (
              <CardTitle className="grow justify-self-start text-sm font-normal">
                {label}
              </CardTitle>
            ) : null}
            <div className="flex items-center justify-between gap-1">
              {item && widthOptions ? (
                <WidthSelector
                  options={widthOptions}
                  value={item.width}
                  onValueChange={(value) =>
                    onItemChange?.({ ...item, width: value })
                  }
                />
              ) : null}
              {form && item ? (
                <Dialog open={open} onOpenChange={onOpenChange}>
                  <Tooltip tooltip={getLabel("ui.edit")}>
                    <DialogTrigger asChild={true}>
                      <Button className="size-7" size="icon" variant="ghost">
                        <Icon name="edit" />
                      </Button>
                    </DialogTrigger>
                  </Tooltip>
                  <DialogContent>
                    <DialogHeader className="border-b">
                      <DialogTitle>{group?.label}</DialogTitle>
                    </DialogHeader>
                    <DialogBody>
                      <VisuallyHidden>
                        <DialogDescription></DialogDescription>
                      </VisuallyHidden>
                      {form.map((field, index) => {
                        return (
                          <FormItem key={index}>
                            <FormLabel required={true}>{field.name}</FormLabel>
                            <FormInputRenderer
                              element={field}
                              value={data[field.handle]}
                              setValue={(value) => {
                                const nextData = { ...data };

                                set(nextData, field.handle, value);

                                setData(nextData);
                              }}
                            />
                            {error && group?.optionValue === field.handle ? (
                              <p className="text-destructive text-sm">
                                {error}
                              </p>
                            ) : null}
                          </FormItem>
                        );
                      })}
                    </DialogBody>
                    <DialogFooter className="border-t">
                      <Button
                        variant="ghost"
                        onClick={() => {
                          setData?.(item);

                          onOpenChange(false);
                        }}
                      >
                        {getLabel("ui.cancel")}
                      </Button>
                      <Button
                        onClick={() => {
                          const oldUniqueIdentifier = get(
                            item,
                            group?.optionValue ?? "value",
                          );
                          const newUniqueIdentifier = get(
                            data,
                            group?.optionValue ?? "value",
                          );

                          if (oldUniqueIdentifier !== newUniqueIdentifier) {
                            if (items.includes(newUniqueIdentifier)) {
                              setError("test");

                              return;
                            }
                          }

                          onItemChange?.(data);
                        }}
                      >
                        {getLabel("ui.save")}
                      </Button>
                    </DialogFooter>
                  </DialogContent>
                </Dialog>
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

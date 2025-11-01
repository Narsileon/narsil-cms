import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { CardContent, CardHeader, CardRoot } from "@narsil-cms/components/card";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { DropdownMenuItem, DropdownMenuSeparator } from "@narsil-cms/components/dropdown-menu";
import { FormRenderer } from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { SortableHandle, SortableItemMenu } from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import type { Block, Field } from "@narsil-cms/types";
import { ComponentProps, useState } from "react";
import { type ArrayElement } from ".";

type ArrayItemProps = Pick<
  ComponentProps<typeof SortableItemMenu>,
  "onMoveDown" | "onMoveUp" | "onRemove"
> & {
  handle?: string;
  id: string | number;
  index?: number;
  item: ArrayElement;
  labelKey: string;
  form?: (Block | Field)[];
  onItemChange?: (value: ArrayElement) => void;
};

function ArrayItem({
  form,
  handle,
  index,
  item,
  id,
  labelKey,
  onMoveDown,
  onMoveUp,
  onRemove,
}: ArrayItemProps) {
  const { trans } = useLocalization();

  const [open, setCollapsed] = useState<boolean>(true);

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
      ref={setNodeRef}
      className={cn(isDragging && "opacity-50")}
      open={open}
      style={{
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
    >
      <CardRoot>
        <CollapsibleTrigger className={cn(open && "border-b")} asChild={true}>
          <CardHeader className="flex min-h-9 items-center justify-between gap-2 py-0! pr-1 pl-0">
            <SortableHandle ref={setActivatorNodeRef} {...attributes} {...listeners} />
            <span className="grow text-start">{item[labelKey] ?? "item"}</span>
            <SortableItemMenu onMoveDown={onMoveDown} onMoveUp={onMoveUp} onRemove={onRemove}>
              <DropdownMenuItem onClick={() => setCollapsed(!open)}>
                <Icon name={open ? "chevron-up" : "chevron-down"} />
                {open ? trans("ui.collapse") : trans("ui.expand")}
              </DropdownMenuItem>
              <DropdownMenuSeparator />
            </SortableItemMenu>
          </CardHeader>
        </CollapsibleTrigger>
        {form ? (
          <CollapsibleContent>
            <CardContent className="grow">
              {form?.map((item) => {
                const defaultHandle = item.handle;

                const finalHandle = `${handle}.${index}.${defaultHandle}`;

                return <FormRenderer {...item} handle={finalHandle} key={defaultHandle} />;
              })}
            </CardContent>
          </CollapsibleContent>
        ) : null}
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default ArrayItem;

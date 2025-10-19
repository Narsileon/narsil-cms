import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { Button } from "@narsil-cms/blocks";
import { CardContent, CardHeader, CardRoot } from "@narsil-cms/components/card";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { FormRenderer } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SortableHandle } from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import type { Block } from "@narsil-cms/types";
import { useState } from "react";
import { type ArrayElement } from ".";

type ArrayItemProps = {
  handle?: string;
  id: string | number;
  index?: number;
  item: ArrayElement;
  labelKey: string;
  block?: Block;
  onItemChange?: (value: ArrayElement) => void;
  onItemRemove?: () => void;
};

function ArrayItem({ block, handle, index, item, id, labelKey, onItemRemove }: ArrayItemProps) {
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
          <CardHeader className="flex min-h-9 items-center justify-between gap-2 !py-0 pl-0 pr-1">
            <SortableHandle ref={setActivatorNodeRef} {...attributes} {...listeners} />
            <span className="grow text-start">{item[labelKey] ?? "item"}</span>
            <div className="flex items-center gap-1">
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
            </div>
          </CardHeader>
        </CollapsibleTrigger>
        {block ? (
          <CollapsibleContent>
            <CardContent className="grow">
              {block?.elements.map((item) => {
                const defaultHandle = item.handle ?? item.element.handle;

                const finalHandle = `${handle}.${index}.${defaultHandle}`;

                return <FormRenderer {...item.element} handle={finalHandle} key={defaultHandle} />;
              })}
            </CardContent>
          </CollapsibleContent>
        ) : null}
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default ArrayItem;

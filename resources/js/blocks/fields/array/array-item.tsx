import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { FormElement } from "@narsil-cms/components/form";
import { SortableItemMenu } from "@narsil-cms/components/sortable";
import type { Element } from "@narsil-cms/types";
import { Button } from "@narsil-ui/components/button";
import { CardContent, CardHeader, CardRoot } from "@narsil-ui/components/card";
import {
  CollapsiblePanel,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-ui/components/collapsible";
import { Icon } from "@narsil-ui/components/icon";
import { SortableHandle } from "@narsil-ui/components/sortable";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { getTranslatableData } from "@narsil-ui/lib/data";
import { cn } from "@narsil-ui/lib/utils";
import { type ComponentProps, useState } from "react";
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
  form: Element[];
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
  const { locale, trans } = useTranslator();

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

  const title = getTranslatableData(item, labelKey, locale);
  const label = open ? trans("ui.collapse") : trans("ui.expand");

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
        <CollapsibleTrigger
          className={cn(open && "border-b")}
          render={
            <CardHeader className="flex min-h-9 items-center justify-between gap-2 py-0! pr-1 pl-0">
              <SortableHandle ref={setActivatorNodeRef} {...attributes} {...listeners} />
              <span className="grow text-start">{title ? title : index}</span>
              <div className="flex items-center gap-1">
                <SortableItemMenu onMoveDown={onMoveDown} onMoveUp={onMoveUp} onRemove={onRemove} />
                <Tooltip tooltip={label}>
                  <Button
                    aria-label={label}
                    size="icon-sm"
                    variant="ghost"
                    onClick={() => setCollapsed(!open)}
                  >
                    <Icon
                      className={cn("duration-300", open ? "rotate-90" : "rotate-0")}
                      name="chevron-right"
                    />
                  </Button>
                </Tooltip>
              </div>
            </CardHeader>
          }
        />
        {form ? (
          <CollapsiblePanel>
            <CardContent className="grow">
              {form?.map((item) => {
                const defaultHandle = item.handle;

                const finalHandle = `${handle}.${index}.${defaultHandle}`;

                return <FormElement {...item} handle={finalHandle} key={defaultHandle} />;
              })}
            </CardContent>
          </CollapsiblePanel>
        ) : null}
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default ArrayItem;

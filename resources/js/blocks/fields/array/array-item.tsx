import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { Button } from "@narsil-cms/components/button";
import { CardContent, CardHeader, CardRoot } from "@narsil-cms/components/card";
import {
  CollapsiblePanel,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { FormElement } from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { SortableHandle, SortableItemMenu } from "@narsil-cms/components/sortable";
import { Tooltip } from "@narsil-cms/components/tooltip";
import { useLocale } from "@narsil-cms/hooks/use-props";
import { cn, getTranslatableSelectOption } from "@narsil-cms/lib/utils";
import type { Element } from "@narsil-cms/types";
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
  const { locale } = useLocale();
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

  const title = getTranslatableSelectOption(item, labelKey, locale);
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

import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { Button } from "@narsil-cms/blocks/button";
import { CardContent, CardHeader, CardRoot, CardTitle } from "@narsil-cms/components/card";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { FormElement } from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { SortableHandle, SortableItem, SortableItemMenu } from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import type { Block } from "@narsil-cms/types";
import { useState, type ComponentProps } from "react";
import { type BuilderElement } from ".";

type BuilderItemProps = Omit<ComponentProps<typeof SortableItem>, "item"> &
  Pick<ComponentProps<typeof SortableItemMenu>, "onMoveDown" | "onMoveUp" | "onRemove"> & {
    baseHandle?: string;
    block: Block;
    item: BuilderElement;
  };

function BuilderItem({
  baseHandle,
  block,
  className,
  collapsed = false,
  id,
  item,
  style,
  onMoveDown,
  onMoveUp,
  onRemove,
  ...props
}: BuilderItemProps) {
  const { trans } = useLocalization();

  const [open, setCollapsed] = useState<boolean>(!collapsed);

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
      className={cn("w-full", isDragging && "opacity-50", className)}
      open={open}
      style={{
        ...style,
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
    >
      <CardRoot {...props}>
        <CollapsibleTrigger className={cn(open && "border-b")} asChild={true}>
          <CardHeader className="flex min-h-9 items-center justify-between gap-2 py-0! pr-1 pl-0">
            <SortableHandle
              ref={setActivatorNodeRef}
              {...attributes}
              {...listeners}
              tooltip={trans("ui.move")}
            />
            <CardTitle className="grow justify-self-start font-normal">{block.label}</CardTitle>
            <div className="flex items-center gap-1">
              <SortableItemMenu onMoveDown={onMoveDown} onMoveUp={onMoveUp} onRemove={onRemove} />
              <Button
                size="icon-sm"
                tooltip={open ? trans("ui.collapse") : trans("ui.expand")}
                variant="ghost"
                onClick={() => setCollapsed(!open)}
              >
                <Icon
                  className={cn("duration-300", open ? "rotate-0" : "rotate-180")}
                  name="chevron-down"
                />
              </Button>
            </div>
          </CardHeader>
        </CollapsibleTrigger>
        <CollapsibleContent>
          <CardContent className="grid-cols-12">
            {block.elements?.map((element, index) => {
              const childElement = element.element;

              const isField = "type" in childElement;

              const translatable = isField ? element.translatable : undefined;

              const childName = element.label ?? childElement.label;
              let childHandle = `${baseHandle}.children.${element.handle}`;

              if (
                isField &&
                childElement.type !== "Narsil\\Contracts\\Fields\\BuilderField" &&
                !translatable
              ) {
                childHandle = `${childHandle}.en`;
              }

              return <FormElement {...element} handle={childHandle} name={childName} key={index} />;
            })}
          </CardContent>
        </CollapsibleContent>
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default BuilderItem;

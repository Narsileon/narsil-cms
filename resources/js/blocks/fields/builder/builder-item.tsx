import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { CardContent, CardHeader, CardRoot, CardTitle } from "@narsil-cms/components/card";
import {
  CollapsibleContent,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { DropdownMenuItem, DropdownMenuSeparator } from "@narsil-cms/components/dropdown-menu";
import { FormRenderer } from "@narsil-cms/components/form";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { SortableHandle, SortableItem, SortableItemMenu } from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import { useState, type ComponentProps } from "react";
import { type BuilderElement } from ".";

type BuilderItemProps = Omit<ComponentProps<typeof SortableItem>, "item"> &
  Pick<ComponentProps<typeof SortableItemMenu>, "onMoveDown" | "onMoveUp" | "onRemove"> & {
    baseHandle?: string;
    item: BuilderElement;
  };

function BuilderItem({
  baseHandle,
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
            <CardTitle className="grow justify-self-start font-normal">{item.block.name}</CardTitle>
            <SortableItemMenu onMoveDown={onMoveDown} onMoveUp={onMoveUp} onRemove={onRemove}>
              <DropdownMenuItem onClick={() => setCollapsed(!open)}>
                <Icon name={open ? "chevron-up" : "chevron-down"} />
                {open ? trans("ui.collapse") : trans("ui.expand")}
              </DropdownMenuItem>
              <DropdownMenuSeparator />
            </SortableItemMenu>
          </CardHeader>
        </CollapsibleTrigger>
        <CollapsibleContent>
          <CardContent>
            {item.block.elements?.map((element, index) => {
              const childElement = element.element;

              const childName = element.name ?? childElement.name;
              let childHandle = `${baseHandle}.fields.${index}.value`;

              if (
                "type" in childElement &&
                childElement.type === "Narsil\\Contracts\\Fields\\BuilderField"
              ) {
                childHandle = `${baseHandle}.children`;
              }

              return (
                <FormRenderer {...childElement} handle={childHandle} name={childName} key={index} />
              );
            })}
          </CardContent>
        </CollapsibleContent>
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default BuilderItem;

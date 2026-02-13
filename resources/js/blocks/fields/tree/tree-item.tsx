import { type UniqueIdentifier } from "@dnd-kit/core";
import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { useForm } from "@narsil-cms/components/form";
import { ModalLink } from "@narsil-cms/components/modal";
import getModelTranslation from "@narsil-cms/lib/get-model-translation";
import { Badge } from "@narsil-ui/components/badge";
import { CardHeader, CardRoot, CardTitle } from "@narsil-ui/components/card";
import { CollapsibleRoot, CollapsibleTrigger } from "@narsil-ui/components/collapsible";
import { SortableHandle } from "@narsil-ui/components/sortable";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import { type ComponentProps } from "react";
import { FlatNode, TreeItemMenu } from ".";

type TreeItemProps = Omit<ComponentProps<typeof CardRoot>, "id"> &
  Pick<ComponentProps<typeof TreeItemMenu>, "onMoveDown" | "onMoveUp" | "onRemove"> & {
    disabled?: boolean;
    id: UniqueIdentifier;
    item: FlatNode;
  };

function TreeItem({
  className,
  item,
  disabled,
  id,
  style,
  onMoveDown,
  onMoveUp,
  ...props
}: TreeItemProps) {
  const { formLanguage } = useForm();
  const { trans } = useTranslator();

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

  const content = (
    <div className="flex grow items-center justify-start gap-2">
      {item.label ? (
        <CardTitle className="font-normal">
          {`${getModelTranslation(item.label, formLanguage, "en")} (id: ${item.id})`}
        </CardTitle>
      ) : null}
      {item.badge ? <Badge variant="secondary">{item.badge}</Badge> : null}
    </div>
  );

  return (
    <CollapsibleRoot
      ref={disabled ? undefined : setNodeRef}
      className={cn(isDragging && "opacity-50", className)}
      style={{
        ...style,
        transform: CSS.Transform.toString(transform),
        transition: transition,
      }}
    >
      <CardRoot {...props}>
        <CollapsibleTrigger
          className={cn(disabled && "cursor-default")}
          nativeButton={false}
          render={
            <CardHeader className="flex min-h-9 items-center justify-start gap-2 py-0 pr-1 pl-0">
              <SortableHandle
                ref={setActivatorNodeRef}
                {...attributes}
                {...listeners}
                disabled={disabled}
              />
              {item.edit_url ? (
                <ModalLink
                  className="grow cursor-pointer"
                  href={item.edit_url as string}
                  variant="right"
                >
                  {content}
                </ModalLink>
              ) : (
                content
              )}
              <TreeItemMenu
                disabled={disabled}
                item={item}
                onMoveDown={onMoveDown}
                onMoveUp={onMoveUp}
              />
            </CardHeader>
          }
        />
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default TreeItem;

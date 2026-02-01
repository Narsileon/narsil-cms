import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { Switch } from "@narsil-cms/blocks/fields/switch";
import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { useAlertDialog } from "@narsil-cms/components/alert-dialog";
import { Button } from "@narsil-cms/components/button";
import { CardContent, CardHeader, CardRoot, CardTitle } from "@narsil-cms/components/card";
import {
  CollapsiblePanel,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-cms/components/collapsible";
import { FormElement, useForm } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { SortableHandle, SortableItem, SortableItemMenu } from "@narsil-cms/components/sortable";
import { cn } from "@narsil-cms/lib/utils";
import type { Block } from "@narsil-cms/types";
import { get } from "lodash-es";
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
  const { setAlertDialog } = useAlertDialog();
  const { data, defaultLanguage, formLanguage, setData } = useForm();
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

  const activeHandle = `${baseHandle}.active`;

  const label = open ? trans("ui.collapse") : trans("ui.expand");

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
        <CollapsibleTrigger
          className={cn(open && "border-b")}
          render={
            <CardHeader className="flex min-h-9 items-center justify-between gap-2 py-0! pr-1 pl-0">
              <SortableHandle
                ref={setActivatorNodeRef}
                {...attributes}
                {...listeners}
                label={trans("ui.move")}
              />
              <CardTitle className="grow justify-self-start font-normal">{block.label}</CardTitle>
              <Switch
                name={`${baseHandle}.active`}
                size="sm"
                checked={
                  get(
                    data,
                    `${activeHandle}.${formLanguage}`,
                    get(data, `${activeHandle}.${defaultLanguage}`, false),
                  ) as boolean
                }
                onCheckedChange={(value) => {
                  setAlertDialog({
                    title: trans(`dialogs.titles.${value ? "activation" : "deactivation"}`),
                    description: trans(
                      `dialogs.descriptions.${value ? "activation" : "deactivation"}`,
                    ),
                    buttons: [
                      {
                        children: trans("dialogs.buttons.this_language"),
                        onClick: () => {
                          setData?.(`${activeHandle}.${formLanguage}`, value);
                        },
                      },
                      {
                        children: trans("dialogs.buttons.all_languages"),
                        onClick: () => {
                          setData?.(activeHandle, {
                            en: value,
                          });
                        },
                      },
                    ],
                  });
                }}
              />
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
                      className={cn("duration-300", open ? "rotate-0" : "rotate-180")}
                      name="chevron-down"
                    />
                  </Button>
                </Tooltip>
              </div>
            </CardHeader>
          }
        />
        <CollapsiblePanel>
          <CardContent className="grid-cols-12">
            {block.elements?.map((element, index) => {
              const child = element.base;

              let childHandle = `${baseHandle}.children.${element.handle}`;

              if ("type" in child) {
                if (
                  child.type !== "Narsil\\Contracts\\Fields\\BuilderField" &&
                  !element.translatable
                ) {
                  childHandle = `${childHandle}.en`;
                }

                return <FormElement {...element} handle={childHandle} key={index} />;
              } else {
                child.virtual = false;

                return <FormElement {...element} base={child} handle={childHandle} key={index} />;
              }
            })}
          </CardContent>
        </CollapsiblePanel>
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default BuilderItem;

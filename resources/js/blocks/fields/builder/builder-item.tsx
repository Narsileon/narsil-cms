import { useSortable } from "@dnd-kit/sortable";
import { CSS } from "@dnd-kit/utilities";
import { SortableItem } from "@narsil-cms/components/sortable";
import { useAlertDialog } from "@narsil-ui/components/alert-dialog";
import { Button } from "@narsil-ui/components/button";
import { CardContent, CardHeader, CardRoot, CardTitle } from "@narsil-ui/components/card";
import {
  CollapsiblePanel,
  CollapsibleRoot,
  CollapsibleTrigger,
} from "@narsil-ui/components/collapsible";
import { FormElement, useForm } from "@narsil-ui/components/form";
import { Icon } from "@narsil-ui/components/icon";
import { SortableHandle, SortableItemMenu } from "@narsil-ui/components/sortable";
import { Switch } from "@narsil-ui/components/switch";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import type { FieldsetData } from "@narsil-ui/types";
import { get } from "lodash-es";
import { useState, type ComponentProps } from "react";
import { type BuilderElement } from ".";

type BuilderItemProps = Omit<ComponentProps<typeof SortableItem>, "item"> &
  Pick<ComponentProps<typeof SortableItemMenu>, "onMoveDown" | "onMoveUp" | "onRemove"> & {
    baseHandle?: string;
    block: FieldsetData;
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
  const { trans } = useTranslator();

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
          nativeButton={false}
          render={
            <CardHeader className="flex min-h-9 items-center justify-between gap-2 py-0! pr-1 pl-0">
              <SortableHandle ref={setActivatorNodeRef} {...attributes} {...listeners} />
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
                    actions: [
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
              let childHandle = `${baseHandle}.children.${element.id}`;

              if ("input" in element) {
                if (element.input.type !== "builder" && !element.translatable) {
                  childHandle = `${childHandle}.en`;
                }

                return <FormElement {...element} id={childHandle} key={index} />;
              } else {
                element.virtual = false;

                return <FormElement {...element} id={childHandle} key={index} />;
              }
            })}
          </CardContent>
        </CollapsiblePanel>
      </CardRoot>
    </CollapsibleRoot>
  );
}

export default BuilderItem;

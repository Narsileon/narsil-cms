import { Button } from "@narsil-ui/components/button";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuTrigger,
} from "@narsil-ui/components/dropdown-menu";
import { Icon } from "@narsil-ui/components/icon";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { useTranslator } from "@narsil-ui/components/translator";
import { cn } from "@narsil-ui/lib/utils";
import type { FieldsetData } from "@narsil-ui/types";
import { useState, type ComponentProps } from "react";
import { type BuilderElement } from ".";

type BuilderAddProps = ComponentProps<typeof DropdownMenuTrigger> & {
  elements: FieldsetData[];
  onAdd: (node: BuilderElement) => void;
};

function BuilderAdd({ elements, onAdd, ...props }: BuilderAddProps) {
  const { trans } = useTranslator();

  const [open, onOpenChange] = useState<boolean>(false);

  return (
    <DropdownMenuRoot open={open} onOpenChange={onOpenChange}>
      <Tooltip tooltip={trans("ui.add")}>
        <DropdownMenuTrigger
          {...props}
          render={
            <Button className={cn("rounded-full")} size="icon-sm" variant="ghost">
              <Icon name="plus" />
            </Button>
          }
        />
      </Tooltip>
      <DropdownMenuPortal>
        <DropdownMenuPositioner>
          <DropdownMenuPopup>
            {elements.map((element, index) => {
              return (
                <DropdownMenuItem
                  onClick={() => {
                    const node = {
                      uuid: crypto.randomUUID(),
                      block_id: element.id as string,
                      children: {},
                    };

                    onAdd(node as BuilderElement);
                  }}
                  key={index}
                >
                  {element.icon ? <Icon name={element.icon} /> : null}
                  <span>{element.label}</span>
                </DropdownMenuItem>
              );
            })}
          </DropdownMenuPopup>
        </DropdownMenuPositioner>
      </DropdownMenuPortal>
    </DropdownMenuRoot>
  );
}

export default BuilderAdd;

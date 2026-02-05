import type { Block } from "@narsil-cms/types";
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
import { useLocalization } from "@narsil-ui/components/localization";
import { Tooltip } from "@narsil-ui/components/tooltip";
import { cn } from "@narsil-ui/lib/utils";
import { useState, type ComponentProps } from "react";
import { type BuilderElement } from ".";

type BuilderAddProps = ComponentProps<typeof DropdownMenuTrigger> & {
  blocks: Block[];
  onAdd: (node: BuilderElement) => void;
};

function BuilderAdd({ blocks, onAdd, ...props }: BuilderAddProps) {
  const { trans } = useLocalization();

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
            {blocks.map((block, index) => {
              return (
                <DropdownMenuItem
                  onClick={() => {
                    const node = { uuid: crypto.randomUUID(), block_id: block.id, children: {} };

                    onAdd(node as BuilderElement);
                  }}
                  key={index}
                >
                  {block.icon ? <Icon name={block.icon} /> : null}
                  <span>{block.label}</span>
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

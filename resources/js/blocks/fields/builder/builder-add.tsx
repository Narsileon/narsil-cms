import { Button } from "@narsil-cms/blocks/button";
import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import type { Block } from "@narsil-cms/types";
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
            <Button className={cn("rounded-full")} icon="plus" size="icon-sm" variant="ghost" />
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

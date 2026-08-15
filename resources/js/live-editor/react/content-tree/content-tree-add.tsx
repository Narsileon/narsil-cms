import { Tooltip } from "@narsil-ui/blocks/tooltip";
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
import { useTranslator } from "@narsil-ui/components/translator";
import type { IconName } from "@narsil-ui/registries/icons";
import { useState, type ComponentProps } from "react";
import type { AllowedBlockData } from "../../core/types";

type ContentTreeAddProps = ComponentProps<typeof DropdownMenuTrigger> & {
  blocks: AllowedBlockData[];
  onAdd: (blockId: number) => void;
};

function ContentTreeAdd({ blocks, onAdd, ...props }: ContentTreeAddProps) {
  const { trans } = useTranslator();

  const [open, onOpenChange] = useState<boolean>(false);

  if (blocks.length === 0) {
    return null;
  }

  return (
    <DropdownMenuRoot open={open} onOpenChange={onOpenChange}>
      <Tooltip tooltip={trans("live-editor.tree.add")}>
        <DropdownMenuTrigger
          {...props}
          render={
            <Button aria-label={trans("live-editor.tree.add")} size="icon-sm" variant="ghost">
              <Icon name="plus" />
            </Button>
          }
        />
      </Tooltip>
      <DropdownMenuPortal>
        <DropdownMenuPositioner align="start">
          <DropdownMenuPopup>
            {blocks.map((block) => {
              return (
                <DropdownMenuItem onClick={() => onAdd(block.block_id)} key={block.block_id}>
                  <Icon name={(block.icon as IconName) ?? "block"} />
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

export default ContentTreeAdd;

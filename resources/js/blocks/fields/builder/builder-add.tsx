import { Button, Tooltip } from "@narsil-cms/blocks";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import type { Block } from "@narsil-cms/types";
import { uniqueId } from "lodash-es";
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
        <DropdownMenuTrigger asChild {...props}>
          <Button className={cn("rounded-full")} icon="plus" size="icon-sm" variant="ghost" />
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent>
        {blocks.map((block, index) => {
          return (
            <DropdownMenuItem
              onClick={() => {
                const node = { uuid: uniqueId("id:"), block: block, fields: [], values: {} };

                onAdd(node as BuilderElement);
              }}
              key={index}
            >
              {block.icon ? <Icon name={block.icon} /> : null}
              <span>{block.name}</span>
            </DropdownMenuItem>
          );
        })}
      </DropdownMenuContent>
    </DropdownMenuRoot>
  );
}

export default BuilderAdd;

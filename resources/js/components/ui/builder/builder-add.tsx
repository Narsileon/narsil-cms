import * as React from "react";
import { Button } from "@narsil-cms/components/ui/button";
import { Icon } from "@narsil-cms/components/ui/icon";
import { uniqueId } from "lodash";
import { Tooltip } from "@narsil-cms/components/ui/tooltip";
import { useLabels } from "@narsil-cms/components/ui/labels";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@narsil-cms/components/ui/dropdown-menu";
import type { Block } from "@narsil-cms/types/forms";
import type { BuilderNode } from ".";

type BuilderAddProps = React.ComponentProps<typeof DropdownMenuTrigger> & {
  blocks: Block[];
  onAdd: (node: BuilderNode) => void;
};

function BuilderAdd({ blocks, onAdd, ...props }: BuilderAddProps) {
  const { trans } = useLabels();

  return (
    <DropdownMenu>
      <Tooltip tooltip={trans("ui.add")}>
        <DropdownMenuTrigger asChild={true} {...props}>
          <Button
            className="hover:bg-secondary size-7 rounded-full"
            size="icon"
            variant="secondary"
          >
            <Icon name="plus" />
          </Button>
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent>
        {blocks.map((block, index) => (
          <DropdownMenuItem
            onClick={() => {
              const node = { id: uniqueId("id:"), block: block };

              onAdd(node as BuilderNode);
            }}
            key={index}
          >
            {block.icon ? <Icon name={block.icon} /> : null}
            <span>{block.name}</span>
          </DropdownMenuItem>
        ))}
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default BuilderAdd;

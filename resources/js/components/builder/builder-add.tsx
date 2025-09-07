import * as React from "react";
import { Button } from "@narsil-cms/components/button";
import { Icon } from "@narsil-cms/components/icon";
import { Tooltip } from "@narsil-cms/blocks";
import { uniqueId } from "lodash";
import { useLabels } from "@narsil-cms/components/labels";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import type { Block } from "@narsil-cms/types/forms";
import type { BuilderNode } from ".";

type BuilderAddProps = React.ComponentProps<typeof DropdownMenuTrigger> & {
  sets: Block[];
  onAdd: (node: BuilderNode) => void;
};

function BuilderAdd({ sets, onAdd, ...props }: BuilderAddProps) {
  const { trans } = useLabels();

  return (
    <DropdownMenuRoot>
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
        {sets.map((set, index) => (
          <DropdownMenuItem
            onClick={() => {
              const node = { id: uniqueId("id:"), block: set, values: {} };

              onAdd(node as BuilderNode);
            }}
            key={index}
          >
            {set.icon ? <Icon name={set.icon} /> : null}
            <span>{set.name}</span>
          </DropdownMenuItem>
        ))}
      </DropdownMenuContent>
    </DropdownMenuRoot>
  );
}

export default BuilderAdd;

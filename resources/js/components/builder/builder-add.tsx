import { uniqueId } from "lodash";
import { useRef, useState, type ComponentProps } from "react";

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

import { type BuilderNode } from ".";

type BuilderAddProps = ComponentProps<typeof DropdownMenuTrigger> & {
  sets: Block[];
  onAdd: (node: BuilderNode) => void;
};

function BuilderAdd({ sets, onAdd, ...props }: BuilderAddProps) {
  const { trans } = useLocalization();

  const [hovered, setHovered] = useState<boolean>(false);
  const [open, onOpenChange] = useState<boolean>(false);

  const hoverTimeout = useRef(null);

  const handleMouseEnter = () => {
    hoverTimeout.current = setTimeout(() => {
      setHovered(true);
    }, 200);
  };

  const handleMouseLeave = () => {
    if (hoverTimeout.current) clearTimeout(hoverTimeout.current);
    setHovered(false);
  };

  return (
    <div
      className="flex w-full flex-col items-center justify-center overflow-hidden"
      onMouseEnter={handleMouseEnter}
      onMouseLeave={handleMouseLeave}
    >
      <div
        className={cn(
          "h-2 w-px border-l border-dashed transition-transform duration-300 ease-out",
          (hovered || open) && "h-4",
        )}
      />
      <DropdownMenuRoot open={open} onOpenChange={onOpenChange}>
        <Tooltip tooltip={trans("ui.add")} contentProps={{ hidden: !hovered }}>
          <DropdownMenuTrigger asChild {...props}>
            <Button
              className={cn(
                "hover:bg-secondary size-0.5 rounded-full opacity-0 transition-all duration-300 ease-out",
                (hovered || open) && "size-7 opacity-100",
              )}
              icon="plus"
              size="icon"
              variant="secondary"
            />
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
      <div
        className={cn(
          "h-2 w-px border-l border-dashed transition-transform duration-300 ease-out",
          (hovered || open) && "h-4",
        )}
      />
    </div>
  );
}

export default BuilderAdd;

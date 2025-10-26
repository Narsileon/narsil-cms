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
import { uniqueId } from "lodash";
import { useRef, useState, type ComponentProps } from "react";
import { type BuilderElement } from ".";

type BuilderAddProps = ComponentProps<typeof DropdownMenuTrigger> & {
  blocks: Block[];
  separatorClassName?: string;
  onAdd: (node: BuilderElement) => void;
};

function BuilderAdd({ blocks, separatorClassName, onAdd, ...props }: BuilderAddProps) {
  const { trans } = useLocalization();

  const [hovered, setHovered] = useState<boolean>(false);
  const [open, onOpenChange] = useState<boolean>(false);

  const hoverTimeout = useRef<number>(0);

  const handleMouseEnter = () => {
    hoverTimeout.current = setTimeout(() => {
      setHovered(true);
    }, 200);
  };

  const handleMouseLeave = () => {
    if (hoverTimeout.current) {
      clearTimeout(hoverTimeout.current);
    }

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
          separatorClassName,
        )}
      />
      <DropdownMenuRoot open={open} onOpenChange={onOpenChange}>
        <Tooltip tooltip={trans("ui.add")} contentProps={{ hidden: !hovered }}>
          <DropdownMenuTrigger asChild {...props}>
            <Button
              className={cn(
                "size-0.5 rounded-full opacity-0 transition-all duration-100 ease-out",
                (hovered || open) && "size-7 opacity-100",
              )}
              icon="plus"
              size="icon-sm"
              variant="secondary"
            />
          </DropdownMenuTrigger>
        </Tooltip>
        <DropdownMenuContent>
          {blocks.map((block, index) => {
            return (
              <DropdownMenuItem
                onClick={() => {
                  const node = { uuid: uniqueId("id:"), block: block, values: {} };

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
      <div
        className={cn(
          "h-2 w-px border-l border-dashed transition-transform duration-300 ease-out",
          (hovered || open) && "h-4",
          separatorClassName,
        )}
      />
    </div>
  );
}

export default BuilderAdd;

import { Button, Tooltip } from "@narsil-cms/blocks";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { type ComponentProps } from "react";

type SortableItemMenuProps = ComponentProps<typeof DropdownMenuTrigger> & {
  onMoveDown?: () => void;
  onMoveUp?: () => void;
  onRemove?: () => void;
};

function SortableItemMenu({
  children,
  onMoveDown,
  onMoveUp,
  onRemove,
  ...props
}: SortableItemMenuProps) {
  const { trans } = useLocalization();

  return (
    <DropdownMenuRoot>
      <Tooltip tooltip={trans("accessibility.toggle_row_menu")}>
        <DropdownMenuTrigger asChild={true} {...props}>
          <div className="flex items-center justify-end">
            <Button
              aria-label={trans("accessibility.toggle_row_menu")}
              icon="more-horizontal"
              size="icon-sm"
              variant="ghost-secondary"
              onClick={(event) => event.stopPropagation()}
            />
          </div>
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent align="end" onClick={(event) => event.stopPropagation()}>
        <DropdownMenuItem disabled={!onMoveUp} onClick={onMoveUp}>
          <Icon name="move-up" />
          {trans("ui.move_up")}
        </DropdownMenuItem>
        <DropdownMenuItem disabled={!onMoveDown} onClick={onMoveDown}>
          <Icon name="move-down" />
          {trans("ui.move_down")}
        </DropdownMenuItem>
        {onRemove ? (
          <>
            <DropdownMenuSeparator />
            <DropdownMenuItem onClick={onRemove}>
              <Icon name="trash" />
              {trans("ui.remove")}
            </DropdownMenuItem>
          </>
        ) : null}
        {children ? (
          <>
            <DropdownMenuSeparator />
            {children}
          </>
        ) : null}
      </DropdownMenuContent>
    </DropdownMenuRoot>
  );
}

export default SortableItemMenu;

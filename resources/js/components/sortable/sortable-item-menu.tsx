import { Button } from "@narsil-cms/components/button";
import {
  DropdownMenuItem,
  DropdownMenuPopup,
  DropdownMenuPortal,
  DropdownMenuPositioner,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { Tooltip } from "@narsil-cms/components/tooltip";
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
        <DropdownMenuTrigger
          {...props}
          render={
            <div className="flex items-center justify-end">
              <Button
                aria-label={trans("accessibility.toggle_row_menu")}
                size="icon-sm"
                variant="ghost-secondary"
                onClick={(event) => event.stopPropagation()}
              >
                <Icon name="more-horizontal" />
              </Button>
            </div>
          }
        />
      </Tooltip>
      <DropdownMenuPortal>
        <DropdownMenuPositioner align="end">
          <DropdownMenuPopup onClick={(event) => event.stopPropagation()}>
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
          </DropdownMenuPopup>
        </DropdownMenuPositioner>
      </DropdownMenuPortal>
    </DropdownMenuRoot>
  );
}

export default SortableItemMenu;

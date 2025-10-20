import { DropdownMenuItem, DropdownMenuSeparator } from "@narsil-cms/components/dropdown-menu";
import { Icon } from "@narsil-cms/components/icon";
import { useLocalization } from "@narsil-cms/components/localization";
import { ModalLink } from "@narsil-cms/components/modal";
import { SortableItemMenu } from "@narsil-cms/components/sortable";
import { type ComponentProps } from "react";
import { FlatNode } from ".";

type TreeItemMenuProps = ComponentProps<typeof SortableItemMenu> & {
  item: FlatNode;
};

function TreeItemMenu({ item, ...props }: TreeItemMenuProps) {
  const { trans } = useLocalization();

  return (
    <SortableItemMenu {...props}>
      <DropdownMenuItem asChild={true}>
        {item.create_url ? (
          <ModalLink href={item.create_url as string} variant="right">
            <Icon name="plus" />
            {trans("ui.add_child")}
          </ModalLink>
        ) : null}
      </DropdownMenuItem>
      <DropdownMenuItem asChild={true}>
        {item.edit_url ? (
          <ModalLink href={item.edit_url as string} variant="right">
            <Icon name="plus" />
            {trans("ui.edit")}
          </ModalLink>
        ) : null}
      </DropdownMenuItem>
      <DropdownMenuSeparator />
    </SortableItemMenu>
  );
}

export default TreeItemMenu;

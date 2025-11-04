import { Link } from "@narsil-cms/blocks";
import { DropdownMenuItem, DropdownMenuSeparator } from "@narsil-cms/components/dropdown-menu";
import { useForm } from "@narsil-cms/components/form";
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
  const { isDirty } = useForm();
  const { trans } = useLocalization();

  return (
    <SortableItemMenu {...props}>
      {item.create_url ? (
        <DropdownMenuItem asChild={true} disabled={isDirty}>
          <ModalLink href={item.create_url as string} variant="right">
            <Icon name="plus" />
            {trans("ui.add_child")}
          </ModalLink>
        </DropdownMenuItem>
      ) : null}

      {item.edit_url ? (
        <DropdownMenuItem asChild={true} disabled={isDirty}>
          <ModalLink href={item.edit_url as string} variant="right">
            <Icon name="edit" />
            {trans("ui.edit")}
          </ModalLink>
        </DropdownMenuItem>
      ) : null}
      {item.destroy_url ? (
        <>
          <DropdownMenuSeparator />
          <DropdownMenuItem asChild={true}>
            <Link href={item.destroy_url as string} method="delete">
              <Icon name="trash" />
              {trans("ui.delete")}
            </Link>
          </DropdownMenuItem>
        </>
      ) : null}
    </SortableItemMenu>
  );
}

export default TreeItemMenu;

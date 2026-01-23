import { router } from "@inertiajs/react";
import { Icon } from "@narsil-cms/blocks/icon";
import { useAlertDialog } from "@narsil-cms/components/alert-dialog";
import { DropdownMenuItem, DropdownMenuSeparator } from "@narsil-cms/components/dropdown-menu";
import { useForm } from "@narsil-cms/components/form";
import { useLocalization } from "@narsil-cms/components/localization";
import { ModalLink } from "@narsil-cms/components/modal";
import { SortableItemMenu } from "@narsil-cms/components/sortable";
import { type ComponentProps } from "react";
import { FlatNode } from ".";

type TreeItemMenuProps = ComponentProps<typeof SortableItemMenu> & {
  disabled?: boolean;
  item: FlatNode;
};

function TreeItemMenu({ disabled, item, ...props }: TreeItemMenuProps) {
  const { setAlertDialog } = useAlertDialog();
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
      {item.destroy_url && !disabled ? (
        <>
          <DropdownMenuSeparator />
          <DropdownMenuItem
            onClick={() => {
              setAlertDialog({
                title: trans("dialogs.titles.delete"),
                description: trans("dialogs.descriptions.delete"),
                buttons: [
                  {
                    onClick: () => {
                      router.delete(item.destroy_url as string);
                    },
                  },
                ],
              });
            }}
          >
            <Icon name="trash" />
            {trans("ui.delete")}
          </DropdownMenuItem>
        </>
      ) : null}
    </SortableItemMenu>
  );
}

export default TreeItemMenu;

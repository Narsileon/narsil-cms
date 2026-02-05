import { router } from "@inertiajs/react";
import { useAlertDialog } from "@narsil-cms/components/alert-dialog";
import { useForm } from "@narsil-cms/components/form";
import { ModalLink } from "@narsil-cms/components/modal";
import { SortableItemMenu } from "@narsil-cms/components/sortable";
import { DropdownMenuItem, DropdownMenuSeparator } from "@narsil-ui/components/dropdown-menu";
import { Icon } from "@narsil-ui/components/icon";
import { useLocalization } from "@narsil-ui/components/localization";
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
        <DropdownMenuItem
          disabled={isDirty}
          render={
            <ModalLink href={item.create_url as string} variant="right">
              <Icon name="plus" />
              {trans("ui.add_child")}
            </ModalLink>
          }
        />
      ) : null}

      {item.edit_url ? (
        <DropdownMenuItem
          disabled={isDirty}
          render={
            <ModalLink href={item.edit_url as string} variant="right">
              <Icon name="edit" />
              {trans("ui.edit")}
            </ModalLink>
          }
        />
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

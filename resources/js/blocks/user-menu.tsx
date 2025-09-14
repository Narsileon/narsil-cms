import { Link } from "@inertiajs/react";

import { Tooltip } from "@narsil-cms/blocks";
import {
  AvatarFallback,
  AvatarImage,
  AvatarRoot,
} from "@narsil-cms/components/avatar";
import { ButtonRoot } from "@narsil-cms/components/button";
import {
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuRoot,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@narsil-cms/components/dropdown-menu";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";
import { ModalLink } from "@narsil-cms/components/modal";
import { useAuth, useNavigation } from "@narsil-cms/hooks/use-props";

type UserMenuProps = React.ComponentProps<typeof DropdownMenuTrigger> & {};

function UserMenu({ ...props }: UserMenuProps) {
  const { trans } = useLabels();

  const auth = useAuth();
  const { userMenu } = useNavigation();

  return (
    <DropdownMenuRoot>
      <Tooltip tooltip={trans("accessibility.toggle_user_menu")}>
        <DropdownMenuTrigger asChild={!auth && true} {...props}>
          {auth ? (
            <AvatarRoot>
              {auth.avatar ? (
                <AvatarImage src={auth.avatar} alt={auth.full_name ?? "User"} />
              ) : null}
              <AvatarFallback>
                <Icon name="user" />
              </AvatarFallback>
            </AvatarRoot>
          ) : (
            <ButtonRoot
              aria-label={trans(
                "accessibility.toggle_user_menu",
                "Toggle user menu",
              )}
              size="icon"
              variant="ghost"
            >
              <Icon name="menu" />
            </ButtonRoot>
          )}
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent align="end">
        {userMenu.content.map((item, index) => {
          switch (item.component) {
            case "separator":
              return <DropdownMenuSeparator key={index} />;
            default:
              const icon = item.icon ? <Icon name={item.icon} /> : null;

              return (
                <DropdownMenuItem asChild={true} key={index}>
                  {item.modal ? (
                    <ModalLink href={item.href}>
                      {icon}
                      {item.label}
                    </ModalLink>
                  ) : (
                    <Link as="button" href={item.href} method={item.method}>
                      {icon}
                      {item.label}
                    </Link>
                  )}
                </DropdownMenuItem>
              );
          }
        })}
      </DropdownMenuContent>
    </DropdownMenuRoot>
  );
}

export default UserMenu;

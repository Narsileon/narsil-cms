import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/react";
import { MenuIcon } from "lucide-react";
import { ModalLink } from "@/components/ui/modal";
import { Tooltip } from "@/components/ui/tooltip";
import { useAuth, useComponents } from "@/hooks/use-props";
import { useLabels } from "@/components/ui/labels";
import UserAvatar from "@/components/app/user/avatar";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { DynamicIcon } from "lucide-react/dynamic";

type UserMenuProps = React.ComponentProps<typeof DropdownMenuTrigger> & {};

function UserMenu({ ...props }: UserMenuProps) {
  const { user_menu } = useComponents();
  const { getLabel } = useLabels();

  const auth = useAuth();

  return (
    <DropdownMenu>
      <Tooltip tooltip={getLabel("accessibility.toggle_user_menu")}>
        <DropdownMenuTrigger asChild={!auth && true} {...props}>
          {auth ? (
            <UserAvatar
              firstName={auth.first_name ?? "A"}
              lastName={auth.last_name ?? "A"}
            />
          ) : (
            <Button
              aria-label={getLabel(
                "accessibility.toggle_user_menu",
                "Toggle user menu",
              )}
              size="icon"
              variant="ghost"
            >
              <MenuIcon />
            </Button>
          )}
        </DropdownMenuTrigger>
      </Tooltip>
      <DropdownMenuContent align="end">
        {user_menu.content.map((item, index) => {
          const icon = item.icon ? <DynamicIcon name={item.icon} /> : null;

          return (
            <DropdownMenuItem key={index} asChild={true}>
              {item.modal ? (
                <ModalLink href={item.href}>
                  {icon}
                  {item.label}
                </ModalLink>
              ) : (
                <Link href={item.href}>
                  {icon}
                  {item.label}
                </Link>
              )}
            </DropdownMenuItem>
          );
        })}
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default UserMenu;

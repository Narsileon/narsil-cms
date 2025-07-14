import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/react";
import { LogInIcon, LogOutIcon, MenuIcon, SettingsIcon } from "lucide-react";
import { ModalLink } from "@/components/ui/modal";
import { route } from "ziggy-js";
import { Tooltip } from "@/components/ui/tooltip";
import { useLabels } from "@/components/ui/labels";
import useAuth from "@/hooks/use-auth";
import UserAvatar from "@/components/app/user/avatar";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

type UserMenuProps = React.ComponentProps<typeof DropdownMenuTrigger> & {};

function UserMenu({ ...props }: UserMenuProps) {
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
        <DropdownMenuItem asChild={true}>
          <ModalLink href={route("user-configuration.index")}>
            <SettingsIcon />
            {getLabel("ui.settings")}
          </ModalLink>
        </DropdownMenuItem>
        <DropdownMenuSeparator />
        <DropdownMenuItem asChild={true}>
          {auth ? (
            <Link as="button" href={route("logout")} method="post">
              <LogOutIcon />
              {getLabel("ui.log_out")}
            </Link>
          ) : (
            <Link as="button" href={route("login")} method="get">
              <LogInIcon />
              {getLabel("ui.log_in")}
            </Link>
          )}
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}

export default UserMenu;

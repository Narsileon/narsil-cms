import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/react";
import { LogInIcon, LogOutIcon, MenuIcon, SettingsIcon } from "lucide-react";
import { route } from "ziggy-js";
import { useState } from "react";
import useAuth from "@/hooks/use-auth";
import UserAvatar from "@/components/app/user/avatar";
import UserSettings from "@/components/app/user/settings";
import useTranslationsStore from "@/stores/translations-store";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import type { DropdownMenuTriggerProps } from "@/components/ui/dropdown-menu";

type UserMenuProps = DropdownMenuTriggerProps & {};

function UserMenu({ ...props }: UserMenuProps) {
  const { trans } = useTranslationsStore();

  const auth = useAuth();

  const [openSettings, setOpenSettings] = useState(false);

  return (
    <>
      <Tooltip>
        <DropdownMenu>
          <TooltipTrigger asChild={true}>
            <DropdownMenuTrigger asChild={true} {...props}>
              {auth ? (
                <UserAvatar
                  firstName={auth.first_name ?? "A"}
                  lastName={auth.last_name ?? "A"}
                />
              ) : (
                <Button
                  aria-label={trans(
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
          </TooltipTrigger>
          <DropdownMenuContent align="end">
            <DropdownMenuItem onClick={() => setOpenSettings(true)}>
              <SettingsIcon />
              {trans("ui.settings", "Settings")}
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem asChild={true}>
              {auth ? (
                <Link as="button" href={route("logout")} method="post">
                  <LogOutIcon />
                  {trans("ui.log_out", "Log out")}
                </Link>
              ) : (
                <Link as="button" href={route("login")} method="get">
                  <LogInIcon />
                  {trans("ui.log_in", "Log in")}
                </Link>
              )}
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
        <TooltipContent>
          {trans("accessibility.toggle_user_menu", "Toggle user menu")}
        </TooltipContent>
      </Tooltip>
      <UserSettings open={openSettings} onOpenChange={setOpenSettings} />
    </>
  );
}

export default UserMenu;

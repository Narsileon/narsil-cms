import { CogIcon, LogOutIcon } from "lucide-react";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import { useState } from "react";
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

function UserMenu() {
  const { trans } = useTranslationsStore();

  const [openSettings, setOpenSettings] = useState(false);

  return (
    <>
      <Tooltip>
        <DropdownMenu>
          <TooltipTrigger asChild>
            <DropdownMenuTrigger>
              <UserAvatar />
            </DropdownMenuTrigger>
          </TooltipTrigger>
          <DropdownMenuContent align="end">
            <DropdownMenuItem onClick={() => setOpenSettings(true)}>
              <CogIcon />
              {trans("ui.settings")}
            </DropdownMenuItem>

            <DropdownMenuSeparator />
            <DropdownMenuItem asChild={true}>
              <Link as="button" href={route("logout")} method="post">
                <LogOutIcon />
                {trans("ui.log_out")}
              </Link>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
        <TooltipContent>{trans("tooltips.toggle.user_menu")}</TooltipContent>
      </Tooltip>
      <UserSettings open={openSettings} onOpenChange={setOpenSettings} />
    </>
  );
}

export default UserMenu;

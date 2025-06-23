import { CogIcon, LogOutIcon } from "lucide-react";
import { Link } from "@inertiajs/react";
import { useRoute } from "ziggy-js";
import { useState } from "react";
import { useTranslationsStore } from "@/stores/translations-store";
import UserAvatar from "../avatar/user-avatar";
import UserSettings from "../settings/user-settings";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

function UserMenu() {
  const route = useRoute();

  const { trans } = useTranslationsStore();

  const [openSettings, setOpenSettings] = useState(false);

  return (
    <>
      <DropdownMenu>
        <DropdownMenuTrigger>
          <UserAvatar />
        </DropdownMenuTrigger>
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
      <UserSettings open={openSettings} onOpenChange={setOpenSettings} />
    </>
  );
}

export default UserMenu;

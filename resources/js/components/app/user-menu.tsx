import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { CogIcon, LogOutIcon } from "lucide-react";
import { Link } from "@inertiajs/react";
import { useRoute } from "ziggy-js";
import { useState } from "react";
import UserSettings from "./user-settings";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

type UserMenuProps = {};

function UserMenu({}: UserMenuProps) {
  const route = useRoute();

  const [openSettings, setOpenSettings] = useState(false);

  return (
    <>
      <DropdownMenu>
        <DropdownMenuTrigger asChild={true}>
          <Avatar>
            <AvatarFallback>FL</AvatarFallback>
          </Avatar>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuItem onClick={() => setOpenSettings(true)}>
            <CogIcon />
            Settings
          </DropdownMenuItem>

          <DropdownMenuSeparator />
          <DropdownMenuItem asChild={true}>
            <Link as="button" href={route("logout")} method="post">
              <LogOutIcon />
              Sign Out
            </Link>
          </DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
      <UserSettings open={openSettings} onOpenChange={setOpenSettings} />
    </>
  );
}

export default UserMenu;

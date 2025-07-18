import { Button } from "@/components/ui/button";
import { DynamicIcon } from "lucide-react/dynamic";
import { Link } from "@inertiajs/react";
import { MenuIcon } from "lucide-react";
import { ModalLink } from "@/components/ui/modal";
import { Tooltip } from "@/components/ui/tooltip";
import { useAuth, useNavigation } from "@/hooks/use-props";
import { useLabels } from "@/components/ui/labels";
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
  const { user_menu } = useNavigation();
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
          switch (item.component) {
            case "separator":
              return <DropdownMenuSeparator key={index} />;
            default:
              const icon = item.icon ? <DynamicIcon name={item.icon} /> : null;

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
    </DropdownMenu>
  );
}

export default UserMenu;

import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { usePage } from "@inertiajs/react";
import type { GlobalProps } from "@/types/global";

function UserAvatar() {
  const { first_name, last_name } = usePage<GlobalProps>().props.auth;

  return (
    <Avatar>
      <AvatarFallback>
        {first_name && last_name ? `${first_name[0]}${last_name[0]}` : "AA"}
      </AvatarFallback>
    </Avatar>
  );
}

export default UserAvatar;

import { Avatar, AvatarFallback } from "@narsil-cms/components/ui/avatar";

type UserAvatarProps = {
  firstName: string;
  lastName: string;
};

function UserAvatar({ firstName, lastName }: UserAvatarProps) {
  return (
    <Avatar>
      <AvatarFallback>{`${firstName[0]}${lastName[0]}`}</AvatarFallback>
    </Avatar>
  );
}

export default UserAvatar;

import {
  Avatar,
  AvatarFallback,
  AvatarImage,
} from "@narsil-cms/components/ui/avatar";

type UserAvatarProps = {
  avatar?: string | null;
  firstName: string;
  lastName: string;
};

function UserAvatar({ avatar, firstName, lastName }: UserAvatarProps) {
  const name = `${firstName[0]}${lastName[0]}`;

  return (
    <Avatar>
      {avatar ? <AvatarImage src={avatar} alt={name} /> : null}
      <AvatarFallback>{name}</AvatarFallback>
    </Avatar>
  );
}

export default UserAvatar;

import {
  AvatarFallback,
  AvatarImage,
  AvatarRoot,
} from "@narsil-cms/components/ui/avatar";

type AvatarProps = {
  avatar?: string | null;
  firstName: string;
  lastName: string;
  fullName: string;
};

function Avatar({ avatar, firstName, lastName, fullName }: AvatarProps) {
  const name = `${firstName[0]}${lastName[0]}`;

  return (
    <AvatarRoot>
      {avatar ? <AvatarImage src={avatar} alt={fullName} /> : null}
      <AvatarFallback>{name}</AvatarFallback>
    </AvatarRoot>
  );
}

export default Avatar;

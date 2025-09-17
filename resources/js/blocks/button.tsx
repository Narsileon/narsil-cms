import { Link } from "@inertiajs/react";

import { ButtonRoot } from "@narsil-cms/components/button";
import { Icon } from "@narsil-cms/components/icon";
import { IconName } from "@narsil-cms/plugins/icons";

type ButtonProps = React.ComponentProps<typeof ButtonRoot> & {
  icon?: IconName;
  iconProps?: React.ComponentProps<typeof Icon>;
  label?: string;
  linkProps?: React.ComponentProps<typeof Link>;
};

function Button({
  asChild = false,
  children,
  icon,
  iconProps,
  label,
  linkProps,
  type,
  ...props
}: ButtonProps) {
  const iconName = icon || iconProps?.name;

  const ButtonContent = (
    <>
      {iconName ? <Icon name={iconName} {...iconProps} /> : null}
      {children ?? label}
    </>
  );

  return (
    <ButtonRoot asChild={linkProps ? true : asChild} type={type} {...props}>
      {linkProps ? <Link {...linkProps}>{ButtonContent}</Link> : ButtonContent}
    </ButtonRoot>
  );
}

export default Button;

import { Link } from "@inertiajs/react";

import { Tooltip } from "@narsil-cms/blocks";
import { ButtonRoot } from "@narsil-cms/components/button";
import { Icon } from "@narsil-cms/components/icon";

type ButtonProps = React.ComponentProps<typeof ButtonRoot> & {
  iconProps?: React.ComponentProps<typeof Icon>;
  label?: string;
  linkProps?: React.ComponentProps<typeof Link>;
  tooltip?: string;
};

function Button({
  asChild = false,
  children,
  iconProps,
  label,
  linkProps,
  tooltip,
  type,
  ...props
}: ButtonProps) {
  const ButtonContent = (
    <>
      {iconProps ? <Icon {...iconProps} /> : null}
      {children ?? label}
    </>
  );

  const ButtonElement = (
    <ButtonRoot asChild={linkProps ? true : asChild} type={type} {...props}>
      {linkProps ? <Link {...linkProps}>{ButtonContent}</Link> : ButtonContent}
    </ButtonRoot>
  );

  if (tooltip) {
    return <Tooltip tooltip={tooltip}>{ButtonElement}</Tooltip>;
  }

  return ButtonElement;
}

export default Button;

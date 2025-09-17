import { Link } from "@inertiajs/react";

import { Tooltip } from "@narsil-cms/blocks";
import { ButtonRoot } from "@narsil-cms/components/button";
import { Icon } from "@narsil-cms/components/icon";
import { IconName } from "@narsil-cms/plugins/icons";

type ButtonProps = React.ComponentProps<typeof ButtonRoot> & {
  icon?: IconName;
  iconProps?: React.ComponentProps<typeof Icon>;
  label?: string;
  linkProps?: React.ComponentProps<typeof Link>;
  tooltip?: string;
  tooltipProps?: React.ComponentProps<typeof Tooltip>;
};

function Button({
  asChild = false,
  children,
  icon,
  iconProps,
  label,
  linkProps,
  tooltip,
  tooltipProps,
  type,
  ...props
}: ButtonProps) {
  const iconName = icon || iconProps?.name;
  const tooltipLabel = tooltip || tooltipProps?.tooltip;

  const ButtonContent = (
    <>
      {iconName ? <Icon name={iconName} {...iconProps} /> : null}
      {children ?? label}
    </>
  );

  const ButtonElement = (
    <ButtonRoot asChild={linkProps ? true : asChild} type={type} {...props}>
      {linkProps ? <Link {...linkProps}>{ButtonContent}</Link> : ButtonContent}
    </ButtonRoot>
  );

  if (tooltipLabel) {
    return (
      <Tooltip tooltip={tooltipLabel} {...tooltipProps}>
        {ButtonElement}
      </Tooltip>
    );
  }

  return ButtonElement;
}

export default Button;

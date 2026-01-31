import { Link } from "@inertiajs/react";
import { Icon } from "@narsil-cms/blocks/icon";
import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { ButtonRoot } from "@narsil-cms/components/button";
import { ModalLink } from "@narsil-cms/components/modal";
import { type IconName } from "@narsil-cms/repositories/icons";
import { omit } from "lodash-es";
import { type ComponentProps } from "react";

type ButtonProps = ComponentProps<typeof ButtonRoot> & {
  icon?: IconName;
  iconProps?: ComponentProps<typeof Icon>;
  label?: string;
  linkProps?: ComponentProps<typeof Link> & {
    modal?: boolean;
  };
  tooltip?: string;
  tooltipProps?: Partial<ComponentProps<typeof Tooltip>>;
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
    <ButtonRoot aria-label={tooltipLabel as string} asChild={linkProps ? true : asChild} {...props}>
      {linkProps ? (
        linkProps.modal ? (
          <ModalLink {...omit(linkProps, ["modal"])}>{ButtonContent}</ModalLink>
        ) : (
          <Link {...linkProps}>{ButtonContent}</Link>
        )
      ) : (
        ButtonContent
      )}
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

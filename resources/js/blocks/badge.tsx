import { BadgeClose, BadgeRoot } from "@narsil-cms/components/badge";
import { type ComponentProps } from "react";

type BadgeProps = ComponentProps<typeof BadgeRoot> & {
  closeProps?: ComponentProps<typeof BadgeClose>;
  onClose?: () => void;
};

function Badge({ children, closeProps, onClose, ...props }: BadgeProps) {
  return (
    <BadgeRoot {...props}>
      {children}
      {closeProps || onClose ? (
        <BadgeClose
          onClick={(event) => {
            event.stopPropagation();

            onClose?.();
          }}
          {...closeProps}
        />
      ) : null}
    </BadgeRoot>
  );
}

export default Badge;

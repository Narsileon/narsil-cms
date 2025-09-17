import { BadgeClose, BadgeRoot } from "@narsil-cms/components/badge";

type BadgeProps = React.ComponentProps<typeof BadgeRoot> & {
  closeProps?: React.ComponentProps<typeof BadgeClose>;
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

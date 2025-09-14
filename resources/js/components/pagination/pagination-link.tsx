import { Slot } from "radix-ui";

import { ButtonRoot, buttonRootVariants } from "@narsil-cms/components/button";
import { cn } from "@narsil-cms/lib/utils";

type PaginationLinkProps = React.ComponentProps<"a"> &
  Pick<React.ComponentProps<typeof ButtonRoot>, "size"> & {
    asChild?: boolean;
    active?: boolean;
    disabled?: boolean;
  };

function PaginationLink({
  asChild = false,
  className,
  active = false,
  disabled = false,
  size = "icon",
  ...props
}: PaginationLinkProps) {
  const Comp = asChild ? Slot.Root : "a";

  return (
    <Comp
      data-slot="pagination-link"
      data-active={active}
      className={cn(
        buttonRootVariants({
          size: size,
          variant: "outline",
        }),
        active && "bg-accent dark:bg-accent",
        disabled && "pointer-events-none opacity-50",
        className,
      )}
      aria-current={active ? "page" : undefined}
      {...props}
    />
  );
}

export default PaginationLink;

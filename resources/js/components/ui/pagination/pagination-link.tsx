import { Button, buttonVariants } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import { Slot as SlotPrimitive } from "radix-ui";

type PaginationLinkProps = React.ComponentProps<"a"> &
  Pick<React.ComponentProps<typeof Button>, "size"> & {
    asChild?: boolean;
    isActive?: boolean;
    isDisabled?: boolean;
  };

function PaginationLink({
  asChild = false,
  className,
  isActive = false,
  isDisabled = false,
  size = "icon",
  ...props
}: PaginationLinkProps) {
  const Comp = asChild ? SlotPrimitive.Slot : "a";

  return (
    <Comp
      data-slot="pagination-link"
      data-active={isActive}
      className={cn(
        buttonVariants({
          variant: isActive ? "outline" : "ghost",
          size,
        }),
        isDisabled ? "pointer-events-none opacity-50" : null,
        className,
      )}
      aria-current={isActive ? "page" : undefined}
      {...props}
    />
  );
}

export default PaginationLink;

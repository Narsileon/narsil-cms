import { cva, type VariantProps } from "class-variance-authority";
import { Slot } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

export const containerVariants = cva(
  cn("mx-auto h-[inherit] min-h-[inherit] w-[inherit] max-w-7xl gap-3 px-3"),
  {
    variants: {
      variant: {
        default: "",
        centered: "flex flex-col items-center justify-center",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

type ContainerProps = React.ComponentProps<"div"> &
  VariantProps<typeof containerVariants> & { asChild?: boolean };

function Container({
  asChild = false,
  className,
  variant,
  ...props
}: ContainerProps) {
  const Comp = asChild ? Slot.Root : "div";

  return (
    <Comp
      data-slot="container"
      className={cn(
        containerVariants({
          className: className,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default Container;

import { cn } from "@narsil-cms/lib/utils";
import { cva, VariantProps } from "class-variance-authority";
import { Slot as SlotPrimitive } from "radix-ui";

export const containerVariants = cva(
  cn("mx-auto min-h-[inherit] h-[inherit] w-[inherit] max-w-7xl gap-3 px-3"),
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
  const Comp = asChild ? SlotPrimitive.Slot : "div";

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

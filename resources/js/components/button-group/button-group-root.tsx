import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import buttonGroupRootVariants from "./button-group-root-variants";

type ButtonGroupRootProps = React.ComponentProps<"div"> &
  VariantProps<typeof buttonGroupRootVariants>;

function ButtonGroupRoot({ className, orientation, ...props }: ButtonGroupRootProps) {
  return (
    <div
      data-slot="button-group-root"
      data-orientation={orientation}
      className={cn(buttonGroupRootVariants({ orientation }), className)}
      role="group"
      {...props}
    />
  );
}

export default ButtonGroupRoot;
